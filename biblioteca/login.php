<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="assets/style.css">
        <script src="https://kit.fontawesome.com/f5052dcd71.js" crossorigin="anonymous"></script>
        <title>Biblioteca Virtual - Login</title>
    </head>
    <?php
        include("assets/menu.php");
        $paige = new Database();
    ?>
    <body>
        <?php
            if (!empty($_POST) && (isset($_POST["iniciarSesion"]) || isset($_POST["registrarse"]))) {
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
                    $empleado = false;
                    $admin = false;
                    $recordar = $paige->sanitize($_POST["rememberMe"]);
            
                } else {
                    echo "<script>alert('ERROR: Algo ha salido mal, por favor inténtelo de nuevo');window.location='index.php'</script>";
                }
            }
            ?>
        <article class="login">
            <style>
                body{
                    background-color: var(--navy);
                }
                article.login {
                    width: 50%;
                    margin: 1.5em auto;
                }
                div.btnLogin {
                    display: inline-block;
                    background-color: var(--navy);
                    border-radius: 3em;
                    margin: 0 30%;
                }
                button.btnSes {
                    font-size: 1em;
                    font-weight: bold;
                    padding: 10px;
                    margin: 5px;
                    border: 1.5px var(--mint) solid;
                    background-color: var(--clearColor);
                    border-radius: 3em;
                }
            </style>

            <div class="btnLogin">
                <button class="btnSes" type="button" onclick="login()">Iniciar sesión</button>
                <button class="btnSes" type="button" onclick="regis()">Registrarse</button>
            </div>
        
            <form class="sesion" action="login.php" method="POST">
                <h1>Iniciar sesión:</h1>
                <label for="correoI">Correo electrónico:</label>
                <input type="email" name="correoI" id="correoI">
        
                <label for="contraI">Contraseña:</label>
                <input type="password" name="contraI" id="contraI">
        
                <input type="checkbox" name="rememberMe"> Recuérdame <br><br>
        
                <button type="submit" name="iniciarSesion" class="submit">Listo!</button>
            </form>
            <form class="sesion" action="login.php" method="POST">
                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" id="nombre">
        
                <label for="apellido">Apellido:</label>
                <input type="text" name="apellido" id="apellido">
        
                <label for="correoR">Correo electrónico:</label>
                <input type="email" name="correoR" id="correoR">
        
                <label for="dui">DUI:</label>
                <input type="number" name="dui" id="dui">
        
                <label for="tel">Número telefónico:</label>
                <input type="number" name="tel" id="tel">
        
                <label for="contraR1">Contraseña:</label>
                <input type="password" name="contraR1" id="contraR1">
        
                <label for="contraR2">Confirmar contraseña:</label>
                <input type="password" name="contraR2" id="contraR2">
        
                <input type="checkbox" name="rememberMe"> Recuérdame <br><br>
        
                <button type="submit" name="registrarse" class="submit">Regístrame!</button>
            </form>
        </article>
    </body>
</html>
