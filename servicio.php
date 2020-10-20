<?php

require_once('funciones.php');

// Obtenemos la URL relativa del script
$uri = "http://" . $_SERVER['SERVER_NAME'] . dirname($_SERVER['REQUEST_URI']);
$url = "$uri/funciones.php";

// Creamos el SoapServer sin especificar el fichero wsdl
$server = new SoapServer(null, array('uri' => $url));

$server->setClass('Funciones');
$server->handle();