<?php
include('assets/menu.php');
include('assets/vars.php');

$login = new Database();
// <----------------------------------------- login ---------------------------------------->
if (!empty($_POST)) {

    if (isset($_POST['iniSes'])) {
        // $usuarios = $login->mostrarElementos('usuarios');
        $username = $_POST['username'];
        $password = $_POST['password'];

        $log = $login->buscarUsuario('usuarios', $username, $password);

        if ($log == true) {
            if ($log->nombre == $username && $log->contrasena == $password) {
                $_SESSION['iniSes'] = true;
                $_SESSION['usuario'] = $username;
                $_SESSION['id'] = $log->ID;

                if ($log->empleado == true) {
                    $_SESSION['emp'] = true;

                    if ($log->admin == true) {
                        $_SESSION['adm'] = true;
                    }

                    echo "<script type='text/javascript'> alert('Bienvenido usuario $username');</script>";

                    $asunto = "El día de " . date('d/m/Y') . ", su cuenta bajo el nombre de $username inició sesión en nuestro sitio web; si no ha sido usted, le recomendamos contactarnos para cambiar su contraseña." . "\n\n" . "- El equipo de La Biblioteca Virtual";

                    mail($log->correoElectronico, 'Alerta de inicio de sesión', $asunto, $_SESSION['header']);

                    header('Location: index.php');
                }
            } else if (($log->nombre == $username && $log->contrasena != $password) || ($log->nombre != $username && $log->contrasena == $password)) {
                echo "<script type='text/javascript'> alert('Nombre de usuario o contraseña incorrectos'); </script>";
            }
        } else if ($log != true) {
            echo "<script type='text/javascript'> alert('Usuario no encontrado, inténtelo de nuevo'); </script>";
        }

// <------------------------------------------- registro ------------------------------------------------------->
    } else if (isset($_POST['regisTer'])) {
        $nombre = $login->sanitize($_POST['nombre']);
        $apellido = $login->sanitize($_POST['apellido']);
        $correo = $login->sanitize($_POST['correo']);
        $dui = $login->sanitize($_POST['dui']);
        $telefono = $login->sanitize($_POST['telefono']);
        $contra1 = $login->sanitize($_POST['contrasenaUno']);
        $contra2 = $login->sanitize($_POST['contrasenaDos']);
        $empleado = false;
        $admin = false;

        if ($contra1 == $contra2) {
            $registrar = $login->anadirUsuario($nombre, $apellido, $correo, $dui, $telefono, $contra2, $empleado, $admin);

            $reg = $login->buscarUsuario('usuarios', $nombre, $contra2);

            if ($reg) {
                $_SESSION['usuario'] = $nombre;
                $_SESSION['id'] = $reg->ID;

                echo "<script>alert('¡Bienvenido $nombre!');window.location='login.php'</script>";

                $asunto = "¡Bienvenido $nombre!" . "\n" . "Le agradecemos por su preferencia hacia nuestro servicio y esperamos que la pueda pasar bien realizando préstamos y revisando nuestro catálogo." . "\n\n" . "- El equipo de La Biblioteca Virtual";

                mail($correo, '¡Bienvenido a nuestra Biblioteca Virtual!', $asunto, $_SESSION['header']);

                header('Location: index.php');
            } else if (!$reg) {
                echo "<script>alert('Ha ocurrido un error, inténtelo de nuevo');window.location='login.php'</script>";
            }
        }
    } else {
        echo "<script>alert('Ha ocurrido un error, inténtelo de nuevo');window.location='login.php'</script>";
    }

    
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Inicio de sesión</title>
    <style>
        :root {
            --navy: #1C1678;
            --lightBlue: #c3ecff;
            --mint: #A3FFD6;
            --clearColor: #cfffe9;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: var(--navy);
        }

        #cajaCambio {
            width: 60%;
            margin: 5% auto;
            position: relative;
            box-shadow: 0 0 0.25em 0.25em rgba(0, 0, 0, 0.2);
            border-radius: 100px;
        }

        .botonCambiar {
            padding: 5%;
            cursor: pointer;
            background: transparent;
            border: 0;
            outline: none;
            position: relative;
            font-weight: bold;
            font-size: 1.5em;
        }

        #caja {
            width: 50%;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
            background-color: var(--mint);
            border-radius: 100px;

            transition: 300ms;
        }

        .contenedor {
            /* border: 2.5px solid #f00; */

            margin-left: 25%;

            position: relative;
            width: 50%;
            height: 150vh;
            overflow: hidden;
        }

        .elementoForm {
            /* border: 2.5px solid #0f0; */

            padding: 25px 30px;
            position: absolute;
            width: 90%;
            border-radius: 25px;
            background-color: var(--mint);

            transition: left 0.5s ease;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-size: 1.4em;
            font-weight: bold;
        }

        input {
            width: calc(100% - 20px);
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 1em;
        }

        button.enviar {
            text-decoration: none;
            background-color: var(--navy);
            color: white;
            margin-top: 15px;
            padding: 12px 24px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        button.enviar:hover {
            background-color: #ccc;
            color: black;
        }

        #login {
            left: 0;
        }

        #regis {
            left: 150%;
        }
    </style>
</head>

<body>
    <div class="contenedor">
        <div id="cajaCambio">
            <div id="caja"></div>
            <button type="button" class="botonCambiar" id="log" onclick="loginvai()">Iniciar Sesión</button>
            <button type="button" class="botonCambiar" id="reg" onclick="registrarvai()">Registrarse</button>
        </div>
        <div id="login" class="elementoForm">
            <form id="login" class="log" method="POST" action="login.php">
                <label for="username">Ingrese su nombre de usuario:</label>
                <input type="text" name="username" placeholder="Usuario" required>

                <br><br>

                <label for="password">Ingrese su contraseña:</label>
                <input type="password" name="password" placeholder="Contraseña" required>

                <button type="submit" class="enviar" name="iniSes">Iniciar Sesión</button>
            </form>
        </div>
        <div id="regis" class="elementoForm">
            <form id="regis" class="log" method="POST" action="login.php">
                <label for="nombre">Ingrese su nombre:</label>
                <input type="text" name="nombre" id="nombre" placeholder="Primer nombre" required="">

                <label for="apellido">Ingrese su apellido:</label>
                <input type="text" name="apellido" id="apellido" placeholder="Primer apellido" required="">

                <label for="telefono">Ingrese su número telefónico:</label>
                <input type="number" name="telefono" id="telefono" setp="8" placeholder="Número de teléfono" required="">

                <label for="correo">Ingrese su correo electrónico:</label>
                <input type="email" name="correo" id="correo" placeholder="Correo electrónico" required="">

                <label for="dui">Ingrese su DUI:</label>
                <input type="number" name="dui" id="dui" placeholder="DUI" required="">

                <label for="contrasenaUno">Ingrese una contraseña:</label>
                <input type="password" name="contrasenaUno" id="contrasenaUno" placeholder="Contraseña" required="">

                <label for="contrasenaDos">Confirmación de la contraseña:</label>
                <input type="password" name="contrasenaDos" id="contrasenaDos" placeholder="Confirmación de la contraseña" required="">

                <button type="submit" class="enviar" name="regisTer">Registrarse</button>
            </form>
        </div>
    </div>
    <script>
        var x = document.getElementById("login");
        var y = document.getElementById("regis");
        var z = document.getElementById("caja");
        var textcolor1 = document.getElementById("log");
        var textcolor2 = document.getElementById("reg");
        textcolor1.style.color = "#1C1678";
        textcolor2.style.color = "#A3FFD6";

        function registrarvai() {
            x.style.left = "-150%";
            y.style.left = "0";
            z.style.left = "50%";
            textcolor2.style.color = "#1C1678";
            textcolor1.style.color = "#A3FFD6";
        }

        function loginvai() {
            x.style.left = "0";
            y.style.left = "150%";
            z.style.left = "0";
            textcolor2.style.color = "#A3FFD6";
            textcolor1.style.color = "#1C1678";
        }
    </script>
</body>

</html>
