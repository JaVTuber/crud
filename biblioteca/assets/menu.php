<?php
    class Database{
        private $con;
        private $dbhost = "localhost";
        private $dbuser = "root";
        private $dbpass = "";
        private $dbname = "biblioteca";

        function __construct()
        {
            $this->conectar();
        }

        // La base del login
        public function login() {
            if (!$_SESSION['iniSes']) {
                header("Location: login.php");
            } else {
                ?>
                <!-- El menú -->
                <div class="meniu">
                    <header>
                        <i class="fa-solid fa-book book"></i>
                        <h1>Biblioteca Virtual</h1>
                    </header>
                    <nav>
                        <ul>
                            <li><a href="index.php">Inicio</a></li>
                            <li><a href="catalogo.php">Catálogo</a></li>
                            <li><a href="prestamo.php">Préstamos</a></li>
                            <?php
                                if($_SESSION['emp'] == true){
                                    ?>
                                    <li><a href="clientes.php">Clientes</a></li>
                                    <?php
                                    if($_SESSION['adm'] == true){
                                        ?>
                                        <li><a href="empleados.php">Empleados</a></li>
                                        <?php
                                    }
                                }
                            ?>
                            <li><a href="assets/logout.php">Cerrar Sesión</a></li>
                        </ul>
                    </nav>
                    <footer>
                        <p>&copy; 2024 Biblioteca Virtual</p>
                    </footer>
                </div>
                <?php
            }
        }

        // Crea la conexión con la base de datos
        public function conectar() {
            $this->con = mysqli_connect($this->dbhost, $this->dbuser, $this->dbpass, $this->dbname);
            if(mysqli_connect_error()){
                die("Conexión a la base de datos fallida." . mysqli_connect_errno() . mysqli_connect_error());
            }
        }

        // Busca y "cacha" un elemento enviado por un formulario (según tengo entendido)
        public function sanitize($var) {
            $retornar = mysqli_real_escape_string($this->con, $var);
            return $retornar;
        }

        // Muestra los registros de la tabla seleccioanda
        public function mostrarElementos($elemento) {
            $elemento = $elemento;
            $sql = "SELECT * FROM `$elemento`";
            $res = mysqli_query($this->con, $sql);
            return $res;
        }

        // Busca un registro en específico de una tabla específica (Sólo uno)
        public function buscarElemento($tabla, $columna, $elemento) {
            $sql = "SELECT * FROM `$tabla` WHERE `$columna` = '$elemento'";
            $res = mysqli_query($this->con, $sql);
            $return = mysqli_fetch_object($res);
            return $return;
        }
        
        //
        public function buscarUsuario($tabla, $usuario, $contrasena) {
            $sql = "SELECT * FROM `$tabla` WHERE `nombre` = '$usuario' AND `contrasena` = '$contrasena'";
            $res = mysqli_query($this->con, $sql);
            $return = mysqli_fetch_object($res);
            return $return;
        }

        // Busca varios registros de una tabla
        public function buscarElementos($tabla, $columna, $elemento) {
            $sql = "SELECT * FROM `$tabla` WHERE `$columna` = '$elemento'";
            $res = mysqli_query($this->con, $sql);
            return $res;
        }

        // Cambia el estado de libro de prestado (0) a devuelto (1)
        public function devolverLibro($idLibro, $idPrestamo) {
            $sql = "UPDATE `librosprestados` SET `devuelto` = 1 WHERE `librosprestados`.`codigoLibro` = '$idLibro' AND `librosprestados`.`codigoPrestamo` = '$idPrestamo'";
            $res = mysqli_query($this->con, $sql);
            if ($res) {
                return true;
            } else {
                return false;
            }
        }

        // Cambia el estado del préstamo de no devuelto (0) a develto (1)
        public function devolverPrestamo($idPrestamo) {
            $sql = "UPDATE `prestamo` SET `confirmado` = 1 WHERE `prestamo`.`ID` = '$idPrestamo'";
            $res = mysqli_query($this->con, $sql);
            if ($res) {
                return true;
            } else {
                return false;
            }
        }

        // Verifica si todos los libros de un préstamo están devueltos
        public function verificarLibro($idPrestamo, $cantidad) {
            $sqlUno = "SELECT COUNT(*) AS `devueltos` FROM `librosprestados` WHERE `codigoPrestamo` = '$idPrestamo' AND `devuelto` = 1";
            $resUno = mysqli_query($this->con, $sqlUno);
            $row = mysqli_fetch_assoc($resUno);
            
            if ($row['devueltos'] == $cantidad) {
                $sqlDos = "UPDATE `prestamo` SET `devuelto` = 1 WHERE `prestamo`.`ID` = '$idPrestamo'";
                $resDos = mysqli_query($this->con, $sqlDos);
                if ($resDos) {
                    return true;
                    echo "<script>alert('¡Prestamo devuelto!');window.location='prestamo.php'</script>";
                } else {
                    return false;
                    echo "<script>alert('Ha ocurrido un error, inténtelo de nuevo');window.location='prestamo.php'</script>";
                }
            }
        }

        // Lo dice el nombre
        public function anadirLibro($titulo, $autor, $editorial, $categoria, $cantidad) {
            $sql = "INSERT INTO `libro` (`titulo`, `autor`, `editorial`, `categoria`, `ejemplaresDisponibles`) VALUES ('$titulo', '$autor', '$editorial', '$categoria', '$cantidad')";
            $res = mysqli_query($this->con, $sql);
            if ($res) {
                return true;
            } else {
                return false;
            }
        }

        // Lo dice el nombre
        public function modificarLibro($isbn, $titulo, $autor, $editorial, $categoria, $cantidad) {
            $sql = "UPDATE `libro` SET `titulo` = '$titulo', `autor` = '$autor', `editorial` = '$editorial', `categoria` = $categoria, `ejemplaresDisponibles` = $cantidad WHERE `libro`.`ISBN` = '$isbn'";
            $res = mysqli_query($this->con, $sql);
            if($res){
                return true;
            } else {
                return false;
            }
        }

        // Lo dice el nombre
        public function eliminarLibro($isbn) {
            $sql = "DELETE FROM `libro` WHERE `ISBN` = '$isbn'";
            $res = mysqli_query($this->con, $sql);
            if($res){
                return true;
            } else {
                return false;
            }
        }

        // Lo dice el nombre
        public function anadirUsuario($nombre, $apellido, $correo, $dui, $telefono, $contra, $empleado, $admin) {
            $sql = "INSERT INTO `usuarios` (`nombre`, `apellido`, `correoElectronico`, `DUI`, `telefono`, `contrasena`, `empleado`, `admin`) VALUES ('$nombre', '$apellido', '$correo', '$dui', '$telefono', '$contra', '$empleado', '$admin')";
            $res = mysqli_query($this->con, $sql);
            if (!$_SESSION['iniSes']) {
                $_SESSION['iniSes'] = true;
            }
            if ($empleado) {
                $_SESSION['emp'] = true;
                if ($admin) {
                    $_SESSION['adm'] = true;
                }
            }
            if ($res) {
                return true;
            } else {
                return false;
            }
        }

        // Lo dice el nombre
        public function modificarUsuario($id, $nombre, $apellido, $correo, $dui, $telefono, $contra, $empleado, $admin) {
            $sql = "UPDATE `cliente` SET `nombre` = '$nombre', `apellido` = '$apellido', `correoElectronico` = '$correo', `DUI` = '$dui', `telefono` = '$telefono', `contrasena` = '$contra', `empleado` = '$empleado', `admin` = '$admin' WHERE `cliente`.`ID` = '$id'";
            $res = mysqli_query($this->con, $sql);
            if($res){
                return true;
            } else {
                return false;
            }
        }
        
        // Lo dice el nombre
        public function eliminarUsuario($id) {
            $sql = "DELETE FROM `cliente` WHERE `ID` = '$id'";
            $res = mysqli_query($this->con, $sql);
            if($res){
                return true;
            } else {
                return false;
            }
        }

        // Registra los préstamos
        public function prestamo($idCliente, $fechaPrestamo, $fechaDevolucion, $cantLibros) {
            $sql = "INSERT INTO `prestamo`(`fechaPrestamo`, `fechaDevolucion`, `cantidadLibro`, `codigoUsuario`) VALUES ('$fechaPrestamo', '$fechaDevolucion', '$cantLibros', '$idCliente')";
            $res = mysqli_query($this->con, $sql);
            if ($res) {
                return true;
            } else {
                return false;
            }
        }

        public function prestamoCant($idPrestamo, $isbn) {
            $sql = "INSERT INTO `librosprestados`(`codigoLibro`, `codigoPrestamo`) VALUES ('$isbn','$idPrestamo')";
            $res = mysqli_query($this->con, $sql);
            if ($res) {
                return true;
            } else {
                return false;
            }
        }

        public function libroPrestamo($isbn, $cant) {
            $sql = "UPDATE `libro` SET  `ejemplaresDisponibles` = $cant WHERE `libro`.`ISBN` = '$isbn'";
            $res = mysqli_query($this->con, $sql);
            if($res){
                return true;
            } else {
                return false;
            }
        }
    }
?>