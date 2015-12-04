<?php
header('Content-Type: text/html; charset=UTF-8');
include("admin/params.php");
include("admin/bd.php");
include("admin/func.php");
$bd = conectar();
$elecciones = array();
$sql = "select id, idAT, nombre, fecha from elecciones order by fecha desc, nombre asc";
$res = $bd->query($sql);
while($fila = $res->fetch_assoc()) {
    $elecciones[$fila["id"]] = array(
        "nombre" =>$fila["nombre"],
        "idAT"   => $fila["idAT"],
        "fecha"  =>Funciones::fecha($fila["fecha"])
    );
}
if(count($elecciones) == 0) {
    $elecciones[0] = array(
        "nombre" =>"",
        "idAT"   => "",
        "fecha"  =>""
    );
}
// valida id
$idE = 0;
if(isset($_GET["e"])) {
    $idE = $bd->real_escape_string($_GET["e"]);
    if(!filter_var(filter_var($idE, FILTER_SANITIZE_NUMBER_INT), FILTER_VALIDATE_INT) || !in_array($idE, array_keys($elecciones)))
        $idE = 0;
}
if($idE == 0)
    $idE = current(array_keys($elecciones));
$idEAT = $elecciones[$idE]["idAT"];

$fechas = array();
$sql = "select distinct fecha from encuestas where eleccion = '$idEAT' and esResultado = 0 order by fecha asc";
$res = $bd->query($sql);
while($fila = $res->fetch_assoc())
    $fechas[$fila["fecha"]] = Funciones::fecha($fila["fecha"]);

$poblaciones = array();
$sql = "select p.nombre, p.nivel, p.idAT from encuestas as e left join poblacion as p on e.poblacion = p.idAT where e.eleccion = '$idEAT' group by p.idAT order by p.nivel asc, p.nombre asc";
$res = $bd->query($sql);
while($fila = $res->fetch_assoc()) {
    if($fila["nivel"] == "")
        continue;
    $poblaciones[$fila["nivel"]][] = array(
        "nombre" =>$fila["nombre"],
        "idAT"   =>$fila["idAT"]
    );
}

include("header.php");
?>
    <div class="row">
        <div class="col-sm-6 tile competencia">
            <div class="row">
                <div class="col-xs-12">
                    <div type="role" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="row">
                            <div class="col-xs-10">
                                <p class="fecha"><?php echo $elecciones[$idE]["fecha"] ?></p>
                                <p><?php echo $elecciones[$idE]["nombre"] ?></p>
                            </div>
                            <div class="col-xs-2">
                                <i class="icon-chevron-sign-down icon-2x btn btn-warning btn-lg btn-eleccion pull-right"></i>
                            </div>
                        </div>
                    </div>
                    <ul class="dropdown-menu">
<?php
foreach ($elecciones as $k => $v) {
    if($k == $idE)
        continue;
?>
                        <li><a href="?e=<?php echo $k ?>"><span><?php echo $v["fecha"] ?></span> <?php echo $v["nombre"] ?></a></li>
<?php
}
?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-sm-6 tile filtros">
            <form class="form-inline form-filtros">
                <div class="row">
                    <div class="col-xs-6">
                        <div class="form-group">
                            <label for="from_date">Desde fecha:</label>
                            <select class="form-control" id="from_date" name="from_date">
                                <option value="0000-00-00">Todas</option>
<?php
foreach ($fechas as $k => $v) {
?>
                                <option value="<?php echo $k ?>"><?php echo $v ?></option>
<?php
}
?>
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="form-group">
                            <label for="poblacion">Población:</label>
                            <select class="form-control" id="poblacion" name="poblacion">
                                <option value="">Todas</option>
<?php
foreach ($poblaciones as $k => $v) {
?>
                                <optgroup label="<?php echo $k ?>">
<?php
    foreach ($v as $vv) {
?>
                                    <option value="<?php echo $vv["idAT"] ?>"><?php echo $vv["nombre"] ?></option>
<?php
    }
?>
                                </optgroup>
<?php
}
?>
                            </select>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-5 tile tabla">
            <table class="table table-hover tabla-resultados">
                <thead>
                <tr>
                    <th></th>
                    <th class="th-col"><span title="promedio" class="tooltip-trigger">AVG<br/><span class="unidad">%</span></span></th>
                    <th class="th-col"><span title="mínimo" class="tooltip-trigger">MIN<br/><span class="unidad">%</span></span></th>
                    <th class="th-col"><span title="máximo" class="tooltip-trigger">MAX<br/><span class="unidad">%</span></span></th>
                    <th class="th-col"><span title="coeficiente de variación" class="tooltip-trigger">CV<br/><span class="unidad">%</span></span></th>
                    <th class="th-col"><span title="encuestas en las que el candidato figura en el primer puesto" class="tooltip-trigger">N1<br/><span class="unidad">#</span></span></th>
                    <th class="th-col"><span title="observaciones (encuestas)" class="tooltip-trigger">OBS<br/><span class="unidad">#</span></span></th>
                    <th class="th-col img"><span title="ver/ocultar círculos y/o líneas" class="tooltip-trigger"><img src="images/chart.png" alt="" /></span></th>
                    <th class="resultado th-col"><span title="resultado final" class="tooltip-trigger">R<br/><span class="unidad">%</span></span></th>
                </tr>
                </thead>
                <tbody></tbody>
                <tfoot>
                    <tr>
                        <td colspan="9">
                            <h5>Referencias:</h5>
                            <table class="table table-condensed">
                                <tbody>
                                <tr>
                                    <td class="ref">AVG</td>
                                    <td>promedio</td>
                                </tr>
                                <tr>
                                    <td class="ref">MIN</td>
                                    <td>mínimo</td>
                                </tr>
                                <tr>
                                    <td class="ref">MAX</td>
                                    <td>máximo</td>
                                </tr>
                                <tr>
                                    <td class="ref">CV</td>
                                    <td>coeficiente de variación</td>
                                </tr>
                                <tr>
                                    <td class="ref">N1</td>
                                    <td>encuestas en las que el candidato figura en el primer puesto</td>
                                </tr>
                                <tr>
                                    <td class="ref">OBS</td>
                                    <td>observaciones (encuestas)</td>
                                </tr>
                                <tr>
                                    <td class="ref"><img src="images/chart.png" alt="" /></td>
                                    <td>ver/ocultar círculos y/o líneas</td>
                                </tr>
                                <tr>
                                    <td class="ref resultado">R</td>
                                    <td>resultado final</td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="col-xs-7 tile grafico">
            <div class="borra" id="borra"></div>
            <form class="form-filtros">
                <div class="encuestas"></div>
            </form>
        </div>
    </div>
</div>
<script>
var idE   = '<?php echo $idE ?>',
    idGet = '?e=<?php echo $idE ?>';
</script>
<script src="js/jquery-1.11.3.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/d3.min.js"></script>
<script src="js/d3-tip.js"></script>
<script src="js/regression.min.js"></script>
<script src="data/<?php echo $idE ?>.json"></script>
<script src="js/chart.js"></script>
<script>
$('.img').popover({
    trigger: 'hover',
    html   : true
});
</script>
</body>
</html>