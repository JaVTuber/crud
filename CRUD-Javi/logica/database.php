<?php
    class Database{
        private $con;
        private $dbhost = "localhost";
        private $dbuser = "root";
        private $dbpass = "";
        private $dbname = "proyecto_juegos";

        function __construct()
        {
            $this->conectar();
        }

        // Conexión a la base de datos
        public function conectar(){
            $this->con = mysqli_connect($this->dbhost, $this->dbuser, $this->dbpass, $this->dbname);
            if(mysqli_connect_error()){
                die("Conexión a la base de datos fallida." . mysqli_connect_errno() . mysqli_connect_error());
            }
        }

        // Ni idea qué hace esto pero es importante (Creo que es para "cachar" la información que ha mandado un formulario)
        public function sanitize($var){
            $retornar = mysqli_real_escape_string($this->con, $var);
            return $retornar;
        }

        // El nombre lo dice
        public function insertarJuego($id, $nombre, $fechaLanzamiento, $descripcion, $consola){
            $sql = "INSERT INTO `juegos` (`id`, `nombre`, `fechalanzamiento`, `descripcion`, `consola`) VALUES ('$id', '$nombre', '$fechaLanzamiento', '$descripcion', '$consola')";
            $res = mysqli_query($this->con, $sql);
            if($res){
                return true;
            } else {
                return false;
            }
        }

        // El nombre lo dice
        public function insertarConsola($id, $nombre){
            $sql = "INSERT INTO `consolas` (`id`, `nombre`) VALUES ('$id', '$nombre')";
            $res = mysqli_query($this->con, $sql);
            if($res){
                return true;
            } else {
                return false;
            }
        }

        // Selecciona todos los juegos registrados en la base de datos para mostrarlos en pantalla
        public function mostrarJuegos(){
            $sql = "SELECT * FROM `juegos`";
            $res = mysqli_query($this->con, $sql);
            return $res;
        }

        // Selecciona todas las consolas registradas en la base de datos para mostrarlos en pantalla
        public function mostrarConsolas(){
            $sql = "SELECT * FROM `consolas`";
            $res = mysqli_query($this->con, $sql);
            return $res;
        }

        // El nombre lo dice
        public function actualizarJuego($id, $nombre, $fechaLanzamiento, $descripcion, $consola){
            $sql = "UPDATE `juegos` SET `nombre` = '$nombre', `fechalanzamiento` = '$fechaLanzamiento', `descripcion` = '$descripcion', `consola` = '$consola' WHERE `juegos`.`id` = '$id'";
            $res = mysqli_query($this->con, $sql);
            if($res){
                return true;
            } else {
                return false;
            }
        }

        // El nombre lo dice
        public function actualizarConsola($id, $nombre){
            $sql = "UPDATE `consolas` SET `nombre` = '$nombre' WHERE `consolas`.`id` = '$id'";
            $res = mysqli_query($this->con, $sql);
            if($res){
                return true;
            } else {
                return false;
            }
        }

        // Selecciona un juego con un ID en específico para mostrarlo en pantalla
        public function buscarJuego($id){
            $sql = "SELECT * FROM `juegos` WHERE `id` = '$id'";
            $res = mysqli_query($this->con, $sql);
            $return = mysqli_fetch_object($res);
            return $return;
        }

        // Selecciona una consola con un ID en específico para mostrarlo en pantalla
        public function buscarConsola($id){
            $sql = "SELECT * FROM `consolas` WHERE `id` = '$id'";
            $res = mysqli_query($this->con, $sql);
            $return = mysqli_fetch_object($res);
            return $return;
        }

        // El nombre lo dice
        public function eliminarJuego($id){
            $sql = "DELETE FROM `juegos` WHERE `id` = '$id'";
            $res = mysqli_query($this->con, $sql);
            if($res){
                return true;
            } else {
                return false;
            }
        }

        // El nombre lo dice
        public function eliminarConsola($id){
            $sql = "DELETE FROM `consolas` WHERE `id` = '$id'";
            $res = mysqli_query($this->con, $sql);
            if($res){
                return true;
            } else {
                return false;
            }
        }
    }
?>