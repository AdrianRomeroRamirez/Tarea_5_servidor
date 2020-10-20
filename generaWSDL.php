<?php
require_once ('funciones.php');
require_once ('WSDLDocument.php');

// Rutas
$uri = "http://" . $_SERVER['SERVER_NAME'] . dirname($_SERVER['REQUEST_URI']);
$url = "$uri/serviciow.php";
// Creo el wsdl
$wsdl = new WSDLDocument("funciones", $url, $uri);

echo $wsdl->saveXml();
?>