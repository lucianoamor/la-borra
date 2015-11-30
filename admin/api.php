<?php
// copia datos de AirTable a base de datos local
include("params.php");
include("auth.php");
include("bd.php");
$bd = conectar();
$c = curl_init();
curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
curl_setopt($c, CURLOPT_HTTPHEADER, $headers);
curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
echo "<pre>";
foreach ($tablas as $k => $v) {
    if(!isset($v["offset"]))
        $v["offset"] = "ini";
    $offset     = $v["offset"];
    $tablaLocal = $v["tabla"];
    $campos     = $v["campos"];
    $sql = "truncate table $tablaLocal";
    $bd->query($sql);
    echo "mysql>\t truncate $tablaLocal \n";
    while($v["offset"] != "fin") {
        $apiOffset = "?limit=$limit";
        if($v["offset"] != "ini")
            $apiOffset = "?limit=$limit&offset=".$v["offset"];
        $queryUrl = $apiUrl.$k.$apiOffset;
        $v["offset"] = apiCall($bd, $c, $queryUrl, $tablaLocal, $campos, $v["offset"]);
        echo "api>\t $queryUrl \n";
    }
}
curl_close($c);
include("json.php");

// -- funciones
function apiCall($bd, $c, $queryUrl, $tablaLocal, $campos, $offset) {
    curl_setopt($c, CURLOPT_URL, $queryUrl);
    $json = curl_exec($c);
    $info = curl_getinfo($c, CURLINFO_HTTP_CODE);
    // -- log
    $sql = "insert into api_log (fecha, tabla, respuesta) values ('".date("Y-m-d H:i:s")."', '$tablaLocal', '$info')";
    $bd->query($sql);
    echo "mysql>\t insert into api_log \n";
    if($info > 200) {
        echo "api>\t error $info [$tablaLocal | $offset] \n";
        return "fin";
    }
    // -- mysql
    $obj = json_decode($json);
    $sqlIns = array();
    foreach($obj->records as $vo) {
        if(count(get_object_vars($vo->fields)) == 0)
            continue;
        $ins = array();
        $ins[] = "null";            // id
        $ins[] = "'".$vo->id."'";   // idAT
        foreach($campos as $kc => $vc) {
            if(!property_exists($vo->fields, $kc))
                $field = "";
            else {
                switch($vc["tipo"]) {
                    case "img":
                        $array = $vo->fields->$kc;
                        $field = "";
                        if(property_exists($array[0], "thumbnails"))
                            $field = $array[0]->thumbnails->small->url;
                        else
                            $field = "images/default.jpg";
                        break;
                    case "id":
                        $array = $vo->fields->$kc;
                        $field = $array[0];
                        break;
                    case "bool":
                        $field = property_exists($vo->fields, $kc);
                        break;
                    default:
                        $field = $vo->fields->$kc;
                }
            }
            $ins[] = clean($field, $vc["tipo"]);
        }
        $sqlIns[] = "(".implode(",", $ins).")";
    }
    $sql = "insert into $tablaLocal values ".implode(",", $sqlIns).";";
    $bd->query($sql);
    echo "mysql>\t insert into $tablaLocal \n";
    // offset
    if(property_exists($obj, "offset"))
        return $obj->offset;
    return "fin";
}

function clean($dato, $tipo) {
    $dato = trim($dato);
    switch ($tipo) {
        case "text":
            $dato = str_replace('"', "'", $dato);
            $dato = filter_var($dato, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
            break;
        case "color":
            $dato = preg_replace("/[^a-fA-F0-9]*/", "", $dato);
            $dato = filter_var($dato, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
            break;
        case "url":
            $dato = filter_var($dato, FILTER_SANITIZE_URL);
            break;
        case "int":
            $dato = filter_var($dato, FILTER_SANITIZE_NUMBER_INT);
            if($dato < 0)
                $dato = 0;
            break;
        case "decimal":
            $dato = filter_var($dato, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            if($dato < 0)
                $dato = 0;
            break;
    }
    return "'".$GLOBALS["bd"]->real_escape_string($dato)."'";
}
?>
