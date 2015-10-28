<?php header('Content-Type: text/html; charset=UTF-8'); ?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8" />
<title>La Borra</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<!--[if lt IE 9]>
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<!--[if gt IE 9]>
<meta http-equiv="X-UA-Compatible" content="IE=9">
<![endif]-->
<link href="css/bootstrap.min.css" rel="stylesheet" />
<link href="css/styles.css" rel="stylesheet" />
<link rel="shortcut icon" href="favicon.ico" />
<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
<link href='https://fonts.googleapis.com/css?family=Ropa+Sans|Open+Sans' rel='stylesheet' type='text/css'>
</head>
<body>
<header>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">La Borra 2.0</a>
            </div>
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="index.php">Argentina</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Otros países <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Brasil</a></li>
                            <li><a href="#">Grecia</a></li>
                            <li><a href="#">EEUU</a></li>
                            <li><a href="#">Paraguay</a></li>
                            <li><a href="#">Uruguay</a></li>
                        </ul>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="about.php">¿Qué es La Borra?</a></li>
                    <li><a href="help.php">Ayuda</a></li>
                    <li><a href="credits.php">Créditos</a></li>
                    <li><a href="http://www.github.com/lucianoamor/la-borra" target="_blank"><i class="icon-github icon-large"></i></a></li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
</header>
<div class="container">
    <div class="row">
        <div class="col-sm-6 tile competencia">
            <div class="row">
                <div class="col-xs-10">
                    <p class="fecha">09/08/2015</p>
                    <p>PASO Presidente</p>
                </div>
                <div class="col-xs-2">
                    <button type="button" class="btn btn-warning btn-lg pull-right"><i class="icon-chevron-sign-down icon-2x"></i></button>
                </div>
            </div>
        </div>
        <div class="col-sm-6 tile filtros">
            <form class="form-inline">
                <div class="row">
                    <div class="col-xs-4">
                        <div class="form-group">
                            <label for="from_date">Desde fecha:</label>
                            <select class="form-control" id="from_date">
                                <option value="-1">Todas</option>
                                <option value="2015-01-23">23/01/2015</option>
                                <option value="2015-02-13">13/02/2015</option>
                                <option value="2015-03-03">03/03/2015</option>
                                <option value="2015-03-09">09/03/2015</option>
                                <option value="2015-03-20">20/03/2015</option>
                                <option value="2015-04-01">01/04/2015</option>
                                <option value="2015-04-15">15/04/2015</option>
                                <option value="2015-04-16">16/04/2015</option>
                                <option value="2015-04-19">19/04/2015</option>
                                <option value="2015-04-26">26/04/2015</option>
                                <option value="2015-04-27">27/04/2015</option>
                                <option value="2015-05-04">04/05/2015</option>
                                <option value="2015-05-06">06/05/2015</option>
                                <option value="2015-05-07">07/05/2015</option>
                                <option value="2015-05-08">08/05/2015</option>
                                <option value="2015-05-11">11/05/2015</option>
                                <option value="2015-05-13">13/05/2015</option>
                                <option value="2015-05-14">14/05/2015</option>
                                <option value="2015-05-15">15/05/2015</option>
                                <option value="2015-05-20">20/05/2015</option>
                                <option value="2015-05-27">27/05/2015</option>
                                <option value="2015-05-28">28/05/2015</option>
                                <option value="2015-05-29">29/05/2015</option>
                                <option value="2015-05-30">30/05/2015</option>
                                <option value="2015-05-31">31/05/2015</option>
                                <option value="2015-06-01">01/06/2015</option>
                                <option value="2015-06-02">02/06/2015</option>
                                <option value="2015-06-04">04/06/2015</option>
                                <option value="2015-06-05">05/06/2015</option>
                                <option value="2015-06-10">10/06/2015</option>
                                <option value="2015-06-11">11/06/2015</option>
                                <option value="2015-06-12">12/06/2015</option>
                                <option value="2015-06-14">14/06/2015</option>
                                <option value="2015-06-15">15/06/2015</option>
                                <option value="2015-06-16">16/06/2015</option>
                                <option value="2015-06-17">17/06/2015</option>
                                <option value="2015-06-19">19/06/2015</option>
                                <option value="2015-06-22">22/06/2015</option>
                                <option value="2015-06-23">23/06/2015</option>
                                <option value="2015-06-25">25/06/2015</option>
                                <option value="2015-06-26">26/06/2015</option>
                                <option value="2015-06-27">27/06/2015</option>
                                <option value="2015-06-28">28/06/2015</option>
                                <option value="2015-06-29">29/06/2015</option>
                                <option value="2015-07-01">01/07/2015</option>
                                <option value="2015-07-02">02/07/2015</option>
                                <option value="2015-07-03">03/07/2015</option>
                                <option value="2015-07-06">06/07/2015</option>
                                <option value="2015-07-07">07/07/2015</option>
                                <option value="2015-07-08">08/07/2015</option>
                                <option value="2015-07-09">09/07/2015</option>
                                <option value="2015-07-10">10/07/2015</option>
                                <option value="2015-07-11">11/07/2015</option>
                                <option value="2015-07-12">12/07/2015</option>
                                <option value="2015-07-13">13/07/2015</option>
                                <option value="2015-07-15">15/07/2015</option>
                                <option value="2015-07-17">17/07/2015</option>
                                <option value="2015-07-18">18/07/2015</option>
                                <option value="2015-07-19">19/07/2015</option>
                                <option value="2015-07-20">20/07/2015</option>
                                <option value="2015-07-22">22/07/2015</option>
                                <option value="2015-07-23">23/07/2015</option>
                                <option value="2015-07-24">24/07/2015</option>
                                <option value="2015-07-25">25/07/2015</option>
                                <option value="2015-07-26">26/07/2015</option>
                                <option value="2015-07-28">28/07/2015</option>
                                <option value="2015-07-29">29/07/2015</option>
                                <option value="2015-07-30">30/07/2015</option>
                                <option value="2015-07-31">31/07/2015</option>
                                <option value="2015-08-01">01/08/2015</option>
                                <option value="2015-08-02">02/08/2015</option>
                                <option value="2015-08-04">04/08/2015</option>
                                <option value="2015-08-05">05/08/2015</option>
                                <option value="2015-08-06">06/08/2015</option>
                                <option value="2015-08-09">09/08/2015</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class="form-group">
                            <label for="poblacion">Población:</label>
                            <select class="form-control" id="poblacion">
                                <option value="-1">Todas</option>
                                <optgroup label="País">
                                    <option value="1">Nacional</option>
                                </optgroup>
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
                    <div class="col-xs-4">
                        <div class="form-group">
                            <label for="encuestadora">Encuestadora:</label>
                            <select class="form-control" id="encuestadora">
                                <option value="-1">Todas</option>
                                <option value="2">Analogías</option>
                                <option value="2">ARESCO</option>
                                <option value="2">Carlos Fara y Asociados</option>
                                <option value="2">CEOP</option>
                                <option value="2">CHM</option>
                                <option value="2">Circuitos</option>
                                <option value="2">Giacobbe & Asociados</option>
                                <option value="2">González y Valladares</option>
                                <option value="2">Ibarómetro</option>
                                <option value="2">KNACK</option>
                                <option value="2">NN</option>
                                <option value="2">Nueva Comunicación</option>
                                <option value="2">Opinión Pública Servicios y Mercados</option>
                                <option value="2">Query</option>
                                <option value="2">Raul Aragón y Asociados</option>
                                <option value="2">Ricardo Rouvier y Asociados</option>
                                <option value="2">Wonder</option>
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
                        <img src="https://dl.airtable.com/KOySa25oS120KwCZAaCX_scioli.jpg" title="Daniel Scioli" class="img fpv" data-content="<small>FPV</small>" data-clase="DanielScioli" />
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
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.6/d3.min.js" charset="utf-8"></script>
<script src="js/d3-tip.js"></script>
<script src="js/data-paso2015.js"></script>
<script src="js/chart.js"></script>
<script>
$('.img').popover({
    trigger: 'hover',
    html   : true
});
</script>
</body>
</html>
