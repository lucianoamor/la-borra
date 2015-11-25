<?php
require("config/config.php");
session_start();
error_reporting(E_ALL);
$apiUrl      = "https://api.airtable.com/v0/$apiId/";
$headers     = array("Authorization: Bearer $apiKey");
$jsonFolder  = "../data/";
$limit       = 100;
// estructura de la tabla de AirTable
$tablas      = array(
    "Agrupaciones" => array(
        "tabla"  => "agrupaciones",
        "campos" => array(
            "Name" => array(
                "columna" => "nombre",
                "tipo"    => "text"
            ),
            "Color" => array(
                "columna" => "color",
                "tipo"    => "color"
            )
        )
    ),
    "Candidatos" => array(
        "tabla"  => "candidatos",
        "campos" => array(
            "Name" => array(
                "columna" => "nombre",
                "tipo"    => "text"
            ),
            "Imagen" => array(
                "columna" => "imagen",
                "tipo"    => "img"
            ),
            "Agrupacion" => array(
                "columna" => "agrupacion",
                "tipo"    => "id"
            )
        )
    ),
    "Elecciones" => array(
        "tabla"  => "elecciones",
        "campos" => array(
            "Name" => array(
                "columna" => "nombre",
                "tipo"    => "text"
            ),
            "Fecha" => array(
                "columna" => "fecha",
                "tipo"    => "fecha"
            )
        )
    ),
    "Encuestadoras" => array(
        "tabla"  => "encuestadoras",
        "campos" => array(
            "Name" => array(
                "columna" => "nombre",
                "tipo"    => "text"
            ),
            "Web" => array(
                "columna" => "web",
                "tipo"    => "url"
            )
        )
    ),
    "Encuestas" => array(
        "tabla"  => "encuestas",
        "campos" => array(
            "Name" => array(
                "columna" => "nombre",
                "tipo"    => "text"
            ),
            "Fecha" => array(
                "columna" => "fecha",
                "tipo"    => "fecha"
            ),
            "Encuestadora" => array(
                "columna" => "encuestadora",
                "tipo"    => "id"
            ),
            "Eleccion" => array(
                "columna" => "eleccion",
                "tipo"    => "id"
            ),
            "Fuente" => array(
                "columna" => "fuente",
                "tipo"    => "url"
            ),
            "Poblacion" => array(
                "columna" => "poblacion",
                "tipo"    => "id"
            ),
            "Muestra" => array(
                "columna" => "muestra",
                "tipo"    => "int"
            ),
            "EsResultado" => array(
                "columna" => "esResultado",
                "tipo"    => "bool"
            )
        )
    ),
    "Poblacion" => array(
        "tabla"  => "poblacion",
        "campos" => array(
            "Name" => array(
                "columna" => "nombre",
                "tipo"    => "text"
            ),
            "Nivel" => array(
                "columna" => "nivel",
                "tipo"    => "text"
            )
        )
    ),
    "Resultados" => array(
        "tabla"  => "resultados",
        "campos" => array(
            "Candidato" => array(
                "columna" => "candidato",
                "tipo"    => "id"
            ),
            "Encuesta" => array(
                "columna" => "encuesta",
                "tipo"    => "id"
            ),
            "Intencion" => array(
                "columna" => "intencion",
                "tipo"    => "decimal"
            )
        )
    )
);
?>