<?php
// se llama por ajax
include("admin/params.php");
include("admin/func.php");
include("admin/bd.php");
$bd = conectar();
$data["tabla"] = "";
// input
$idE = 0;
if(isset($_POST["id"])) {
    $idE = $bd->real_escape_string($_POST["id"]);
    if(!filter_var(filter_var($idE, FILTER_SANITIZE_NUMBER_INT), FILTER_VALIDATE_INT))
        $idE = 0;
}
if($idE == 0) {
    echo json_encode($data);
    exit;
}

$desde     = 0;
$poblacion = 0;
$filtros   = array();
if(isset($_POST["from_date"])) {
    $desde = $bd->real_escape_string($_POST["from_date"]);
    $desdeE = explode("-", $desde);
    if(checkdate($desdeE[1], $desdeE[2], $desdeE[0]) === false || $desde == "0000-00-00")
        $desde = 0;
}
if($desde > 0)
    $filtros[] = "enc.fecha >= '$desde'";

if(isset($_POST["poblacion"]))
    $poblacion = $bd->real_escape_string($_POST["poblacion"]);
if($poblacion != "")
    $filtros[] = "enc.poblacion = '$poblacion'";

if(count($filtros) == 0)
    $filtros[] = "1 = 1"; // para sql valido

$encuestas     = array();
$encuestadoras = array();
$sql = "select enc.idAT as encuesta, enc.fecha, enc.fuente, encs.idAT as encuestadoraID, encs.nombre as encuestadora, p.nombre as poblacion from encuestas as enc left join encuestadoras as encs on enc.encuestadora = encs.idAT left join poblacion as p on enc.poblacion = p.idAT left join elecciones as e on enc.eleccion = e.idAT where e.id = $idE and enc.esResultado = 0 and ".implode(" and ", $filtros)." order by enc.fecha asc, p.nivel asc";
$res = $bd->query($sql);
if($res->num_rows > 0) {
    while($fila = $res->fetch_assoc()) {
        $encuestadoras[$fila["encuestadoraID"]] = $fila["encuestadora"];
        $encuestas[$fila["encuestadoraID"]][] = array(
            "encID"     =>$fila["encuesta"],
            "fecha"     =>$fila["fecha"],
            "fuente"    =>$fila["fuente"],
            "poblacion" =>$fila["poblacion"]
        );
    }
}
if($res->num_rows == 0) {
    $data["tabla"] .= '<p class="pull-left"><span class="nEnc">0</span> encuestas</p>';
    echo json_encode($data);
    exit;
}

// checkboxs son inputs disabled. si uncheck, enable (manda por post solo los unchecked)

$txtEnc = "encuestas";
if($res->num_rows == 1)
    $txtEnc = "encuesta";
$data["tabla"] .= '
<p class="pull-left"><span class="nEnc">'.$res->num_rows.'</span> '.$txtEnc.'</p>
<table class="table table-hover table-condensed">
    <tbody>';
foreach ($encuestadoras as $k => $v) {
    $data["tabla"] .= '
        <tr class="tr-encs">
            <td class="encuestadora"><button type="button" class="btn btn-xs btn-success enc-check encs-check"><i class="icon-check"></i></button><input type="hidden" name="encuestadoras[]" value="'.$k.'" disabled></td>
            <td colspan="4"><strong>'.$v.'</strong></td>
        </tr>';
    foreach ($encuestas[$k] as $vv) {
        $link = "";
        if($vv["fuente"] != "")
            $link = '<a href="'.$vv["fuente"].'" target="_blank"><i class="icon-link"></i></a>';
        $data["tabla"] .= '
        <tr class="tr-enc">
            <td></td>
            <td><button type="button" class="btn btn-xs btn-success enc-check"><i class="icon-check"></i></button><input type="hidden" name="encuestas[]" value="'.$vv["encID"].'" disabled></td>
            <td>'.Funciones::fecha($vv["fecha"]).'</td>
            <td>'.$vv["poblacion"].'</td>
            <td>'.$link.'</td>
        </tr>';
    }
}
$data["tabla"] .= '
    </tbody>
</table>';
echo json_encode($data);
?>