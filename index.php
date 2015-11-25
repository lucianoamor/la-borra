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
$sql = "select fecha from encuestas where eleccion = '$idEAT' order by fecha asc";
$res = $bd->query($sql);
while($fila = $res->fetch_assoc())
    $fechas[$fila["fecha"]] = Funciones::fecha($fila["fecha"]);

$poblaciones = array();
$niveles = array("País"=>1, "Región"=>2, "Provincia"=>3, "Partido"=>4, "Localidad"=>5);
$sql = "select p.nombre, p.nivel, p.idAT from encuestas as e left join poblacion as p on e.poblacion = p.idAT where e.eleccion = '$idEAT' order by p.nombre asc";
$res = $bd->query($sql);
while($fila = $res->fetch_assoc()) {
    $poblaciones[$niveles[$fila["nivel"]]][] = array(
        "nombre"=>$fila["nombre"],
        "idAT"=>$fila["idAT"];
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
            <form class="form-inline">
                <div class="row">
                    <div class="col-xs-6">
                        <div class="form-group">
                            <label for="from_date">Desde fecha:</label>
                            <select class="form-control" id="from_date">
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
                            <select class="form-control" id="poblacion">
                                <option value="0">Todas</option>
<?php
foreach ($poblaciones as $k => $v) {
?>
                                <optgroup label="País">
                                    <option value="1">Nacional</option>
                                </optgroup>
<?php
}
?>
                                <optgroup label="Región">
                                    <option value="2">CABA + GBA</option>
                                    <option value="2">CABA + PBA</option>
                                    <option value="2">GBA</option>
                                </optgroup>
                                <optgroup label="Provincia">
                                    <option value="2">CABA</option>
                                    <option value="2">Buenos Aires</option>
                                    <option value="2">Chubut</option>
                                    <option value="2">Córdoba</option>
                                    <option value="2">Jujuy</option>
                                    <option value="2">Mendoza</option>
                                    <option value="2">Río Negro</option>
                                    <option value="2">San Juan</option>
                                    <option value="2">Tucumán</option>
                                </optgroup>
                                <optgroup label="Partido">
                                    <option value="2">Hurlingham</option>
                                    <option value="2">Ituzaingó</option>
                                    <option value="2">La Matanza</option>
                                    <option value="2">Morón</option>
                                </optgroup>
                                <optgroup label="Localidad">
                                    <option value="2">Formosa, Formosa</option>
                                    <option value="2">La Plata, Buenos Aires</option>
                                    <option value="2">La Rioja, La Rioja</option>
                                    <option value="2">Rosario, Santa Fe</option>
                                </optgroup>
                            </select>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-5 tile tabla">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th></th>
                    <th class="th-col">AVG<br/><span>%</span></th>
                    <th class="th-col">MIN<br/><span>%</span></th>
                    <th class="th-col">MAX<br/><span>%</span></th>
                    <th class="th-col">CV<br/><span>%</span></th>
                    <th class="th-col">OBS<br/><span>#</span></th>
                    <th class="th-col">T<br/><span><i class="icon-bar-chart"></i></span></th>
                    <th class="prediccion th-col">LB<br/><span>%</span></th>
                    <th class="resultado th-col">R<br/><span>%</span></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="text-center">
                        <!-- <strong>Daniel Scioli</strong><br/> -->
                        <img src="https://dl.airtable.com/KOySa25oS120KwCZAaCX_scioli.jpg" title="Daniel Scioli" alt="Daniel Scioli" class="img fpv" data-content="<small>FPV</small>" data-clase="DanielScioli" />
                        <!-- <br/>FPV -->
                    </td>
                    <td class="text-center">30</td>
                    <td class="text-center">5</td>
                    <td class="text-center">56</td>
                    <td class="text-center">31</td>
                    <td class="text-center">94</td>
                    <td class="text-center"><a href="#">ver</a></td>
                    <td class="prediccion text-center">35</td>
                    <td class="resultado text-center">36,3</td>
                </tr>
                <tr>
                    <td class="text-center">
                        <!-- <strong>Mauricio Macri</strong><br/> -->
                        <img src="https://dl.airtable.com/p3opGjZtRyeRB5pIhccR_24396.jpg" title="Mauricio Macri" class="img pro" data-content="<small>PRO</small>" data-clase="MauricioMacri" />
                        <!-- <br/>PRO -->
                    </td>
                    <td class="text-center">26</td>
                    <td class="text-center">12</td>
                    <td class="text-center">61</td>
                    <td class="text-center">26</td>
                    <td class="text-center">94</td>
                    <td class="text-center"><a href="#">ver</a></td>
                    <td class="prediccion text-center">25</td>
                    <td class="resultado text-center">23</td>
                </tr>
                <tr>
                    <td class="text-center">
                        <img src="https://dl.airtable.com/Ipp6vusBQEqTKfoybUcu_Massa.jpg" title="Sergio Massa" class="img fr" data-content="<small>FR</small>" data-clase="SergioMassa" />
                    </td>
                    <td class="text-center">14</td>
                    <td class="text-center">3</td>
                    <td class="text-center">28</td>
                    <td class="text-center">39</td>
                    <td class="text-center">93</td>
                    <td class="text-center"><a href="#">ver</a></td>
                    <td class="prediccion text-center">13</td>
                    <td class="resultado text-center">13,5</td>
                </tr>
                <tr>
                    <td class="text-center">
                        <img src="https://dl.airtable.com/fBXnRC05SM2NzhcFQnjc_randazzo_2015.jpg" title="Florencio Randazzo" class="img fpv" data-content="<small>FPV</small>" data-clase="FlorencioRandazzo" />
                    </td>
                    <td class="text-center">11</td>
                    <td class="text-center">3</td>
                    <td class="text-center">22</td>
                    <td class="text-center">37</td>
                    <td class="text-center">44</td>
                    <td class="text-center"><a href="#">ver</a></td>
                    <td class="prediccion text-center">10</td>
                    <td class="resultado text-center">8</td>
                </tr>
                <tr>
                    <td class="text-center">
                        <img src="https://dl.airtable.com/ZXssmW4LQ1aqHy8Gkz7p_24239.jpg" title="Julio Cobos" class="img ucr" data-content="<small>UCR</small>" data-clase="JulioCobos" />
                    </td>
                    <td class="text-center">5</td>
                    <td class="text-center">1</td>
                    <td class="text-center">9</td>
                    <td class="text-center">52</td>
                    <td class="text-center">4</td>
                    <td class="text-center"><a href="#">ver</a></td>
                    <td class="prediccion text-center">-</td>
                    <td class="resultado text-center">-</td>
                </tr>
                <tr>
                    <td class="text-center">
                        <img src="https://dl.airtable.com/6DYvbYmQSiu26CvvA0pw_De-la-sota-11.jpg" title="José Manuel De La Sota" class="img fr" data-content="<small>FR</small>" data-clase="JoséManuelDelaSota" />
                    </td>
                    <td class="text-center">4</td>
                    <td class="text-center">1</td>
                    <td class="text-center">22</td>
                    <td class="text-center">76</td>
                    <td class="text-center">72</td>
                    <td class="text-center"><a href="#">ver</a></td>
                    <td class="prediccion text-center">5</td>
                    <td class="resultado text-center">6</td>
                </tr>
                <tr>
                    <td class="text-center">
                        <img src="https://dl.airtable.com/TPIu6KCjTCPJbPH6k8BH_STOLBIZER1.jpg" title="Margarita Stolbizer" class="img fap" data-content="<small>FAP</small>" data-clase="MargaritaStolbizer" />
                    </td>
                    <td class="text-center">4</td>
                    <td class="text-center">0</td>
                    <td class="text-center">10</td>
                    <td class="text-center">42</td>
                    <td class="text-center">74</td>
                    <td class="text-center"><a href="#">ver</a></td>
                    <td class="prediccion text-center">2</td>
                    <td class="resultado text-center">3</td>
                </tr>
                <tr>
                    <td class="text-center">
                        <img src="images/blanco.gif" title="Blanco" class="img blanco" data-content="" data-clase="VotoenBlanco" />
                    </td>
                    <td class="text-center">5</td>
                    <td class="text-center">2</td>
                    <td class="text-center">6</td>
                    <td class="text-center">25</td>
                    <td class="text-center">5</td>
                    <td class="text-center"><a href="#">ver</a></td>
                    <td class="prediccion text-center">4</td>
                    <td class="resultado text-center">4</td>
                </tr>
                <tr>
                    <td class="text-center">
                        <img src="images/blanco.gif" title="Blanco" class="img blanco" data-content="" data-clase="VotoenBlanco" />
                    </td>
                    <td class="text-center">5</td>
                    <td class="text-center">2</td>
                    <td class="text-center">6</td>
                    <td class="text-center">25</td>
                    <td class="text-center">5</td>
                    <td class="text-center"><a href="#">ver</a></td>
                    <td class="prediccion text-center">4</td>
                    <td class="resultado text-center">4</td>
                </tr>
                </tbody>
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
                                    <td class="ref">OBS</td>
                                    <td>observaciones</td>
                                </tr>
                                <tr>
                                    <td class="ref">T</td>
                                    <td>tendencia (regresión polinomial)</td>
                                </tr>
                                <tr>
                                    <td class="ref prediccion">LB</td>
                                    <td>predicción de La Borra</td>
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
            <div class="encuestas">
                <p class="pull-left"><span>91</span> encuestas</p>
                <button type="button" class="btn btn-success pull-right btn-ver-encuestas"><i class="icon-plus-sign icon-large"></i></button>
                <p class="hidden separador">&nbsp;</p>
                <table class="table table-hover table-condensed hidden">
                    <tbody>
                    <tr>
                        <td>15/08/2015</td>
                        <td>Carlos Fara y Asociados</td>
                        <td>Provincia de Buenos Aires</td>
                        <td><a href="http://" target="_blank"><i class="icon-link"></i></a></td>
                    </tr>
                    <tr>
                        <td>15/08/2015</td>
                        <td>Carlos Fara y Asociados</td>
                        <td>Provincia de Buenos Aires</td>
                        <td><a href="http://" target="_blank"><i class="icon-link"></i></a></td>
                    </tr>
                    <tr>
                        <td>15/08/2015</td>
                        <td>Carlos Fara y Asociados</td>
                        <td>Provincia de Buenos Aires</td>
                        <td><a href="http://" target="_blank"><i class="icon-link"></i></a></td>
                    </tr>
                    <tr>
                        <td>15/08/2015</td>
                        <td>Carlos Fara y Asociados</td>
                        <td>Provincia de Buenos Aires</td>
                        <td><a href="http://" target="_blank"><i class="icon-link"></i></a></td>
                    </tr>
                    <tr>
                        <td>15/08/2015</td>
                        <td>Carlos Fara y Asociados</td>
                        <td>Provincia de Buenos Aires</td>
                        <td><a href="http://" target="_blank"><i class="icon-link"></i></a></td>
                    </tr>
                    <tr>
                        <td>15/08/2015</td>
                        <td>Carlos Fara y Asociados</td>
                        <td>Provincia de Buenos Aires</td>
                        <td><a href="http://" target="_blank"><i class="icon-link"></i></a></td>
                    </tr>
                    <tr>
                        <td>15/08/2015</td>
                        <td>Carlos Fara y Asociados</td>
                        <td>Provincia de Buenos Aires</td>
                        <td><a href="http://" target="_blank"><i class="icon-link"></i></a></td>
                    </tr>
                    <tr>
                        <td>15/08/2015</td>
                        <td>Carlos Fara y Asociados</td>
                        <td>Provincia de Buenos Aires</td>
                        <td><a href="http://" target="_blank"><i class="icon-link"></i></a></td>
                    </tr>
                    <tr>
                        <td>15/08/2015</td>
                        <td>Carlos Fara y Asociados</td>
                        <td>Provincia de Buenos Aires</td>
                        <td><a href="http://" target="_blank"><i class="icon-link"></i></a></td>
                    </tr>
                    <tr>
                        <td>15/08/2015</td>
                        <td>Carlos Fara y Asociados</td>
                        <td>Provincia de Buenos Aires</td>
                        <td><a href="http://" target="_blank"><i class="icon-link"></i></a></td>
                    </tr>
                    <tr>
                        <td>15/08/2015</td>
                        <td>Carlos Fara y Asociados</td>
                        <td>Provincia de Buenos Aires</td>
                        <td><a href="http://" target="_blank"><i class="icon-link"></i></a></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
var idE = '?e=<?php echo $idE ?>';
</script>
<script src="js/jquery-1.11.3.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/d3.min.js"></script>
<script src="js/d3-tip.js"></script>
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