<?php
// include("params.php");
// include("bd.php");
// $bd = conectar();
// echo "<pre>";
$json = array();
$sql = "select ele.id, enc.fecha, enc.idAT as encuestaId, enc.muestra, enc.fuente, res.intencion, encs.nombre as encuestadora, encs.idAT as encuestadoraId, pob.nombre as poblacion, pob.idAT as poblacionId, agr.color, agr.nombre as agrupacion, can.idAT as candidatoId, can.nombre as candidato, can.imagen, enc.esResultado from elecciones as ele left join encuestas as enc on enc.eleccion = ele.idAT left join resultados as res on res.encuesta = enc.idAT left join encuestadoras as encs on encs.idAT = enc.encuestadora left join poblacion as pob on pob.idAT = enc.poblacion left join candidatos as can on can.idAT = res.candidato left join agrupaciones as agr on agr.idAT = can.agrupacion order by ele.id";
$res = $bd->query($sql);
while($fila = $res->fetch_assoc()) {
    $json[$fila["id"]][] = array(
        "fecha"          => $fila["fecha"],
        "resultado"      => (float)$fila["intencion"],
        "encuestadora"   => $fila["encuestadora"],
        "poblacion"      => $fila["poblacion"],
        "color"          => $fila["color"],
        "esRes"          => (int)$fila["esResultado"],
        "candidatoId"    => $fila["candidatoId"],
        "candidato"      => $fila["candidato"],
        "imagen"         => $fila["imagen"],
        "encuestaId"     => $fila["encuestaId"],
        "muestra"        => $fila["muestra"],
        "fuente"         => $fila["fuente"],
        "agrupacion"     => $fila["agrupacion"],
        "encuestadoraId" => $fila["encuestadoraId"],
        "poblacionId"    => $fila["poblacionId"]
    );
}
foreach($json as $k => $v) {
    $f = fopen($jsonFolder.$k.".json", "w");
    fwrite($f, "data = ".json_encode($v).";");
    echo "json>\t $k \n";
    fclose($f);
}
?>