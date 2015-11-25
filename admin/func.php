<?php
class Funciones {
    public static function fecha($fecha) {
        if($fecha == "" || $fecha == "0000-00-00")
            return "";
        $fArray = explode("-", $fecha);
        return $fArray[2]."/".$fArray[1]."/".$fArray[0];
    }
}
?>