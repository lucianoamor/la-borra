<?php
function conectar() {
    $bd = $GLOBALS["bbdd"];
    $mysqli = new mysqli($bd["host"], $bd["user"], $bd["pass"], $bd["base"]);
    if(mysqli_connect_error()) {
        echo "Error de conexión";
        exit;
    }
    $mysqli->set_charset("utf8");
    return $mysqli;
}
?>