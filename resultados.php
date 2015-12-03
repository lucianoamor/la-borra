<?php
// se llama por ajax
include("admin/params.php");
include("admin/bd.php");
$bd = conectar();
$_SESSION["encuestadoras"] = array();
$_SESSION["encuestas"]     = array();
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

$desde         = 0;
$poblacion     = 0;
$filtros       = array();
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

if(isset($_POST["encuestadoras"])) {
    $filtroE = array();
    foreach ($_POST["encuestadoras"] as $v) {
        $filtroE[] = "encs.idAT != '".$bd->real_escape_string($v)."'";
        $_SESSION["encuestadoras"][] = $v;
    }
    $filtros[] = implode(" and ", $filtroE);
}

if(isset($_POST["encuestas"])) {
    $filtroE = array();
    foreach ($_POST["encuestas"] as $v) {
        $filtroE[] = "enc.idAT != '".$bd->real_escape_string($v)."'";
        $_SESSION["encuestas"][] = $v;
    }
    $filtros[] = implode(" and ", $filtroE);
}

if(count($filtros) == 0)
    $filtros[] = "1 = 1"; // para sql valido

$candidatos = array();
$intencion  = array();
$encuestas  = array();
$sql = "select c.nombre, c.imagen, a.nombre as agrupacion, c.idAT as cID, r.intencion, a.color, enc.idAT as encuestaID from elecciones as e left join encuestas as enc on enc.eleccion = e.idAT left join encuestadoras as encs on enc.encuestadora = encs.idAT left join poblacion as p on enc.poblacion = p.idAT left join resultados as r on r.encuesta = enc.idAT left join candidatos as c on r.candidato = c.idAT left join agrupaciones as a on c.agrupacion = a.idAT where e.id = $idE and enc.esResultado = 0 and ".implode(" and ", $filtros)." order by r.intencion asc"; // ordena por si hay alguna encuesta con mas de un dato para el mismo candidato. en $encuestas queda el mas alto, para calcular N1
$res = $bd->query($sql);
if($res->num_rows > 0) {
    while($fila = $res->fetch_assoc()) {
        $intencion[$fila["cID"]][] = $fila["intencion"];
        $candidatos[$fila["cID"]] = array(
            "nombre"     =>$fila["nombre"],
            "imagen"     =>$fila["imagen"],
            "color"      =>$fila["color"],
            "agrupacion" =>$fila["agrupacion"]
        );
        $encuestas[$fila["encuestaID"]][$fila["cID"]] = $fila["intencion"];
    }
}

$maxEncuesta = array();
foreach ($candidatos as $k => $v)
    $maxEncuesta[$k] = 0;
foreach ($encuestas as $eID => $v) {
    $max = max($v);
    $maxK = array_keys($v, $max);
    foreach ($maxK as $vv)
        $maxEncuesta[$vv]++;
}

$resultados = array();
$sql = "select c.idAT as cID, r.intencion from elecciones as e left join encuestas as enc on enc.eleccion = e.idAT left join resultados as r on r.encuesta = enc.idAT left join candidatos as c on r.candidato = c.idAT where e.id = $idE and enc.esResultado = 1 order by enc.fecha asc"; // por si hay mas de 1
$res = $bd->query($sql);
if($res->num_rows == 0) {
    foreach ($candidatos as $k => $v)
        $resultados[$k] = "-";
}
else {
    while($fila = $res->fetch_assoc())
        $resultados[$fila["cID"]] = $fila["intencion"];
}

$n   = array();
$max = array();
$min = array();
$avg = array();
$cv  = array();
$n1  = array(); // n en que candidato esta 1ro
foreach ($intencion as $k => $v) {
    $n[$k]   = count($v);
    $max[$k] = round(max($v), 1);
    $min[$k] = round(min($v), 1);
    if($n[$k] > 0) {
        $avg[$k] = round(array_sum($v) / $n[$k], 1);
        $cv[$k]  = round(dvStd($v) / $avg[$k] * 100, 1);
    }
    else {
        $avg[$k] = 0;
        $cv[$k]  = 0;
    }
    $n1[$k] = $maxEncuesta[$k];
    if(!isset($resultados[$k]))
        $resultados[$k] = "-";
}
arsort($avg);

foreach ($avg as $k => $v) {
    $data["tabla"] .= '
    <tr>
        <td class="text-center">
            <img src="'.$candidatos[$k]["imagen"].'" title="'.$candidatos[$k]["nombre"].'" alt="'.$candidatos[$k]["nombre"].'" class="img" style="border-color:#'.$candidatos[$k]["color"].';" data-content="<small>'.$candidatos[$k]["agrupacion"].'</small>" data-clase="c-'.$k.'" />
        </td>
        <td class="text-center">'.$v.'</td>
        <td class="text-center">'.$min[$k].'</td>
        <td class="text-center">'.$max[$k].'</td>
        <td class="text-center">'.$cv[$k].'</td>
        <td class="text-center">'.$n1[$k].'</td>
        <td class="text-center">'.$n[$k].'</td>
        <td class="text-center"><a href="#">ver</a></td>
        <td class="resultado text-center">'.$resultados[$k].'</td>
    </tr>';
}

if($data["tabla"] == "")
    $data["tabla"] = '
    <tr>
        <td colspan="9" class="text-center">No hay encuestas que coincidan con los filtros elegidos</td>
    </tr>';
echo json_encode($data);

//
function dvStd($a) {
    $n   = count($a);
    if($n == 0)
        return 0;
    $avg = array_sum($a) / $n;
    $vz  = 0;
    foreach ($a as $v)
        $vz += pow($v - $avg, 2);
    return sqrt($vz / $n);
}
?>