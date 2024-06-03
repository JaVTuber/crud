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
        include('assets/vars.php');

        $mainMenu = new Database();
        $inicio = $mainMenu->login();
    ?>
    <!-- Página incompleta -->
    <body>
        <article class="inicio">
            <h1 id="Inicio">Inicio</h1>
            <main>
                <?php
                    if ($_SESSION['emp'] == true) {
                        $id = $_SESSION['id'];
                        $usuario = $_SESSION['usuario'];

                        $mensaje = "<p>Bienvenido, empleado N<sup>o</sup> $id $usuario </p><p>Explore el catálogo, realice préstamos, añada libros y clientes, modifique sus valores y sea honesto y confiable para poder volverse administrador.</p>";
                        if ($_SESSION['adm'] == true) {
                            $mensaje = "<p>Bienvenido, aministrador N<sup>o</sup> $id $usuario </p><p>Explore el catálogo; realice préstamos; añada libros, clientes y libros; modifiqe sus valores y procure dar el ejemplo</p>";
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
