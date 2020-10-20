<?php

// Obtenemos la URL relativa del script
$uri = "http://" . $_SERVER['SERVER_NAME'] . dirname($_SERVER['REQUEST_URI']);
$url = "$uri/servicio.php";

// Llamada sin WSDL
$cliente = new SoapClient(null, array('location' => $url, 'uri' => $uri));

// Obtengo el array de los anunciantes desbloqueados
$desbloqueados = $cliente->getDesbloqueados();
// Obtengo la fecha de hoy
$fechaHoy = date("Y-m-d");

// Si puslo el boton para mandar la fecha, guardo los anuncios correspondientes a ese periodo
if (isset($_POST['mandarFecha'])) {
    $fecha = $_POST['fecha'];
    $anuncios = $cliente->getEscaparate($fecha);
}

$email = "";

// Si pulso el boton de buscar email, guardo la busqueda a la BD
if (isset($_POST['buscarEmail'])) {
    $login = $_POST['login'];
    $email = $cliente->getAnunciantes($login);
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="style.css"/>
        <title>Pagina principal</title>
    </head>
    <body>
        <h1 style="color: red">Esto es cliente.php</h1>
        <h1>Anunciantes</h1>
        <!-- Creo una tabla con los anunciantes desbloqueados-->
        <div class="container">
            <table>
                <thead>
                    <tr>
                        <th>Login</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Si hay datos, los recorro creando las celdas
                    if (isset($desbloqueados)) {
                        foreach ($desbloqueados as $usuario) {
                            echo '<tr>';
                            echo '<td>' . $usuario['login'] . '</td>';
                            echo '<td>' . $usuario['email'] . '</td>';
                            echo '</tr>';
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <h1>Escaparate</h1>
        <!-- Creo una tabla con los anuncios -->
        <div class="container">
            <table>
                <thead>
                    <tr>
                        <th>Autor</th>
                        <th>Moroso</th>
                        <th>Localidad</th>
                        <th>Descripción</th>
                        <th>Fecha</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Si hay datos, los recorro creando las celdas
                    if (isset($anuncios)) {
                        foreach ($anuncios as $anuncio) {
                            echo '<tr>';
                            echo '<td>' . $anuncio['autor'] . '</td>';
                            echo '<td>' . $anuncio['moroso'] . '</td>';
                            echo '<td>' . $anuncio['localidad'] . '</td>';
                            echo '<td>' . $anuncio['descripcion'] . '</td>';
                            echo '<td>' . $anuncio['fecha'] . '</td>';
                            echo '<td>' . $anuncio['email'] . '</td>';
                            echo '</tr>';
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <!-- Creo un formulario para pedir la fecha -->
        <div class="formulario">
            <form action="cliente.php" method="POST">
                <label for="fecha">Fecha:</label>
                <input type="date" id="fecha" name="fecha" value="<?php echo $fechaHoy ?>" required/><br/>
                <button type="submit" id="mandarFecha" name="mandarFecha">Ver anuncios</button>
            </form>
        </div>
        <h1>Consulta Email por login:</h1>
        <!-- Pido el login del usuario que se quiere conocer su email -->
        <div class="container">
            <?php
            if (isset($email)) {
                // Si existe el campo email y no está vacio, se muestra el resultado
                if ($email != "") {
                    echo '<h3>El email del usuario ' . $login . ' es ' . $email . '</h3>';
                }
            // Si es null, es que no ha encontrado el usuario y muestra un mensaje de error
            } else {
                echo '<h3>No existe ese usuario.</h3>';
            }
            ?>
        </div>
        <div class="formulario">
            <form action="cliente.php" method="POST">
                <label for="email2login">Login:</label>
                <input type="text" id="login" name="login" required/><br/>
                <button type="submit" id="buscarEmail" name="buscarEmail">Buscar Email</button>
            </form>
        </div>
        <div>
            <a href="clientew.php">Ir a clientew.php</a>
        </div>
    </body>
</html>

