<?php

require_once('funciones.php');

// Ruta
$uri = "http://" . $_SERVER['SERVER_NAME'] . dirname($_SERVER['REQUEST_URI']);

// Creo el servidor con wsdl
$server = new SoapServer("$uri/funciones.wsdl");

// Le añado la clase funciones
$server->setClass('funciones');
$server->handle();


