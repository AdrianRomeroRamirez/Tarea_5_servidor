<?php

/**
 * Clase Funciones
 */
class funciones {

    /**
     * Se conecta a una base de datos
     * @return \PDO
     */
    private function accesoBD() {
        try {
            // Array con opciones
            $arrOptions = array(
                PDO::ATTR_EMULATE_PREPARES => FALSE,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"
            );
            // se crea la conexión
            $con = new PDO('mysql:host=localhost;dbname=morosos', 'dwes', 'abc123.', $arrOptions);
            return $con;
        } catch (Exception $e) { // Se controla las excepciones
            print $e->getMessage();
            die();
        }
    }

    /**
     * Devuelve los anunciantes no bloqueados
     * @return array
     */
    public function getDesbloqueados() {
        try {
            // Array donde se guardan los anunciantes desbloqueados
            $listaDesbloqueados = Array();
            $sql = "SELECT * FROM anunciantes WHERE bloqueado = 0";
            $con = self::accesoBD();
            $resultado = $con->prepare($sql);
            $resultado->execute();
            // Mientras haya resultados se guardan en el array
            while ($registro = $resultado->fetch()) {
                array_push($listaDesbloqueados, $registro);
            }
            return $listaDesbloqueados;
        } catch (Exception $e) { // Se controla las excepciones
            print $e->getMessage();
            die();
        }
    }

    /**
     * Devulve los anuncios desde la fecha actual hasta la fecha recibida por paŕametro
     * @param string $fecha Fecha hasta la que se busca anuncios
     * @return array
     */
    public function getEscaparate($fecha) {
        try {
            // Dale a tu cuerpo alegria Macarena
            $anuncios = Array();
            $sql = "SELECT anuncios.*, anunciantes.email FROM anuncios JOIN anunciantes ON anunciantes.login = anuncios.autor WHERE anuncios.fecha <= ? ORDER BY anuncios.fecha DESC";
            $con = self::accesoBD();
            $resultado = $con->prepare($sql);
            $resultado->execute([$fecha]);
            // Mientras haya resultados se guardan en el array
            while ($registro = $resultado->fetch()) {
                array_push($anuncios, $registro);
            }
            return $anuncios;
        } catch (Exception $e) { // Se controla las excepciones
            print $e->getMessage();
            die();
        }
    }

    /**
     * Devuelve el email del usuario pasado por parametro
     * @param string $login login del ususario que se quiere conocer su email
     * @return array
     */
    public function getAnunciantes($login) {
        try{
            $sql = "SELECT * from anunciantes WHERE login = ?";
            $con = self::accesoBD();
            $resultado = $con->prepare($sql);
            $resultado->execute([$login]);
            $registro = $resultado->fetch();
            // Si existe el usuario, se devuelve, si no, devuelve null
            if($registro){
                return $registro['email'];
            }else{
                return null;
            }
        } catch (Exception $e) {
            print $e->getMessage();
            die();
        }
    }

}
