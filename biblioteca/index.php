<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="assets/style.css">
        <script src="https://kit.fontawesome.com/f5052dcd71.js" crossorigin="anonymous"></script>
        <title>Biblioteca Virtual - Inicio</title>
    </head>
    <?php
        include("assets/menu.php");
        $mainMenu = new Database();
        $sesion = $mainMenu->login();
    ?>
    <!-- Página incompleta -->
    <body>
        <?php  
            if (!empty($_POST)) {
                if (isset($_POST["cant"]) && isset($_POST["idC"])) {
                    $cant = $mainMenu->sanitize($_POST["cant"]);
                    $idC = $mainMenu->sanitize($_POST["idC"]);
                    $dateE = $mainMenu->sanitize($_POST["date"]);
                    $dateD = $dateE."+1 Months";
                    $libIng; $libAlm = array();
                    $libAlmBD = $mainMenu->mostrarElementos('libro');
                    while ($row = mysqli_fetch_object($libAlmBD)) {
                        $libAlm[-1] = $row->ISBN;
                    }
                }
                if (isset($_POST["iniciarSesion"])) {
                    $correo = $paige->sanitize($_POST["correoI"]);
                    $contrasena = $paige->sanitize($_POST["contraI"]);
                    if (isset($_POST["rememberMe"])) {
                        $recordar = $paige->sanitize($_POST["rememberMe"]);
                    }
            
                    $iniSesion = $paige->buscarUsuario($correo, $contrasena);
            
                } else if (isset($_POST["registrarse"])) {
                    $nombre = $paige->sanitize($_POST["nombre"]);
                    $apellido = $paige->sanitize($_POST["apellido"]);
                    $correo = $paige->sanitize($_POST["correoR"]);
                    $dui = $paige->sanitize($_POST["dui"]);
                    $telefono = $paige->sanitize($_POST["tel"]);
                    $contra1 = $paige->sanitize($_POST["contraR1"]);
                    $contra2 = $paige->sanitize($_POST["contraR2"]);
                    $recordar = $paige->sanitize($_POST["rememberMe"]);
            
                } else {
                    echo "<script>alert('ERROR: Algo ha salido mal, por favor inténtelo de nuevo');window.location='index.php'</script>";
                }
            }
            ?>
        <article class="inicio">
            <h1 id="Inicio">Inicio</h1>
            <main>
                <?php
                    if ($mainMenu->emp == true) {
                        $mensaje = '<p>Bienvenido, empleado N<sup>o</sup> 123 Nombre</p><p>Explore el catálogo, realice préstamos, añada libros y clientes, modifique sus valores y sea honesto y confiable para poder volverse administrador.</p>';
                        if ($mainMenu->adm == true) {
                            $mensaje = '<p>Bienvenido, aministrador N<sup>o</sup> 321 Nombre</p><p>Explore el catálogo; realice préstamos; añada libros, clientes y libros; modifiqe sus valores y procure dar el ejemplo</p>';
                        }
                        echo $mensaje;
                    } else {
                        ?>
                            <p>Bienvenido a nuestra Biblioteca Virtual.</p>
                            <p>Explore nuestro catálogo y realice préstamos de libros, siempre tratando a todos con honestidad y respeto.</p>
                        <?php
                    }
                ?>
            </main>
        </article>
    </body>
</html>
