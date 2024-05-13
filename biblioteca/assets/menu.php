<?php
    class Database{
        public $iniSes = true;
        public $emp = true;
        public $adm = true;

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
            if (!$this->iniSes) {
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
                                $empleado = true;
                                $admin = true;
                                if($empleado){
                                    ?>
                                    <li><a href="clientes.php">Clientes</a></li>
                                    <?php
                                    if($admin){
                                        ?>
                                        <li><a href="empleados.php">Empleados</a></li>
                                        <?php
                                    }
                                }
                            ?>
                            <li><a href="index.php">Cerrar Sesión</a></li>
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

        // Busca un registro en específico de una tabla específica
        public function buscarElemento($tabla, $columna, $elemento) {
            $sql = "SELECT * FROM `$tabla` WHERE `$columna` = '$elemento'";
            $res = mysqli_query($this->con, $sql);
            $return = mysqli_fetch_object($res);
            return $return;
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
            if (!$this->iniSes) {
                $this->iniSes = true;
            }
            if ($empleado) {
                $this->emp = true;
                if ($admin) {
                    $this->adm = true;
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
            $sql = "INSERT INTO `prestamo`(`fechaPrestamo`, `fechaDevolucion`, `cantidadLibro`, `codigoCliente`) VALUES ('$fechaPrestamo', '$fechaDevolucion', '$cantLibros', '$idCliente')";
            $res = mysqli_query($this->con, $sql);
            if ($res) {
                return true;
            } else {
                return false;
            }
        }

        public function prestamoCant($idCantidad, $idPrestamo, $isbn) {
            $sql = "INSERT INTO `librosprestados`(`ID`, `codigoLibro`, `codigoPrestamo`) VALUES ('$idCantidad','$isbn','$idPrestamo')";
            $res = mysqli_query($this->con, $sql);
            if ($res) {
                return true;
            } else {
                return false;
            }
        }

        public function buscarUsuario($correo, $contra) {
            $sql = "SELECT * FROM `usuarios` WHERE `usuarios`.`correoElectronico` = '$correo' AND `usuarios`.`contrasena` = '$contra';";
            $res = mysqli_query($this->con, $sql);
            if ($res) {
                $this->iniSes = true;
                header("Location: index.php");
                echo "algo";
                $row = mysqli_fetch_object($res);
                if ($row->empleado) {
                    $this->emp = true;
                    if ($row->admin) {
                        $this->adm = true;
                    }
                }
            } else {
                echo "<script>alert('Usuario no existe');window.location='index.php'</script>";
            }
        }
    }
?>