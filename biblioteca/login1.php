<?php
    include('assets/menu.php');
    include('assets/vars.php');
    
    $login = new Database();

    if(!empty($_POST)) {
        if (isset($_POST['iniSes'])) {
            $usuarios = $login->mostrarElementos('usuarios');
            $users = array();
            $passs = array();
            $identificador = array();
            $isEmp = array();
            $isAdm = array();

            while ($row = mysqli_fetch_object($usuarios)) {
                $identificador[] = $row->ID;
                $users[] = $row->nombre;
                $passs[] = $row->contrasena;
                $isEmp[] = $row->empleado;
                $isAdm[] = $row->admin;

                /*
                $i = 0;
                echo $i , ", " , $users[$i] , ", " , $passs[$i] , ", " , $isEmp[$i] , ", " , $isAdm[$i] , "<br>";
                $i++;
                */
            }

            $username = $_POST['username'];
            $password = $_POST['password'];

            for ($i=0; $i <= count($users); $i++) { 
                if ($username == $users[$i] && $password == $passs[$i]) {
                    $_SESSION['iniSes'] = true;
                    $_SESSION['usuario'] = $username;
                    $_SESSION['id'] = $identificador[$i];

                    if ($isEmp[$i] == true) {
                        $_SESSION['emp'] = true;

                        if ($isAdm[$i] == true) {
                            $_SESSION['adm'] = ($username == 'admin');
                        }
                    }
                }
            }

            echo "<script>alert('¡Bienvenido $username!');window.location='login.php'</script>";

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

                $_SESSION['iniSes'] = true;
                $_SESSION['emp'] = false;
                $_SESSION['adm'] = false;

                $usuarios = $login->mostrarElementos('usuarios');
                $users = array();
                $passs = array();
                $identificador = array();

                while ($row = mysqli_fetch_object($usuarios)) {
                    $identificador[] = $row->ID;
                    $users[] = $row->nombre;
                    $passs[] = $row->contrasena;
                }

                for ($i=0; $i <= count($users); $i++) { 
                    if ($nombre == $users[$i] && $contra2 == $passs[$i]) {
                        $_SESSION['usuario'] = $nombre;
                        $_SESSION['id'] = $identificador[$i];
                    }
                }

                echo "<script>alert('¡Bienvenido $nombre!');window.location='login.php'</script>";
            }
        } else {
            echo "<script>alert('Ha ocurrido un error, inténtelo de nuevo');window.location='login.php'</script>";
        }

        header('Location: index.php');
    }
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            /* Variables */
            :root {
                --navy: #1C1678;
                --lightBlue: #c3ecff;
                --mint: #A3FFD6;
                --clearColor: #cfffe9;
            }

            /* Estilos del login */
            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
                background-color: var(--navy);
            }

            #contenedor {
                background-color: #344955;
                width: 50%;
                height: 100%;
                position: relative;
                overflow: hidden;
                
                margin-left: 25%;
            }

            #cajaCambio {
                width: 30%;
                height: 100%;
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

            .elementoForm {
                position: relative;
                width: 100%;
                transition: left 0.5s ease-in-out;
            }

            form.log {
                padding: 25px 30px;
                border-radius: 25px;
                background-color: var(--mint);

                transition: 500ms;
            }

            #login {
                top: 0;
                left: 0;
            }

            #regis {
                top: 0;
                left: 150%;
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
        </style>
        <title>Inicio de Sesión</title>
    </head>
    <body>
        <div id="center">
            <div id="cajaCambio">
                <div id="caja"></div>
                <button type="button" class="botonCambiar" id="log" onclick="loginvai()">Iniciar Sesión</button>
                <button type="button" class="botonCambiar" id="reg" onclick="registrarvai()">Registrarse</button>
            </div>
            <div id="contenedor">
                <div class="elementoForm">
                    <form id="login" class="log" method="POST" action="login.php">
                        <label for="username">Ingrese su nombre de usuario:</label>
                        <input type="text" name="username" placeholder="Usuario" required>

                        <br><br>

                        <label for="password">Ingrese su contraseña:</label>
                        <input type="password" name="password" placeholder="Contraseña" required>
                        
                        <button type="submit" class="enviar" name="iniSes">Iniciar Sesión</button>
                    </form>
                </div>
                <div class="elementoForm">
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
                    
                    <?php if (isset($error)): ?>
                    <p style="color: red;"><?php echo $error; ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <script>
            var x = document.getElementById("login");
            var y = document.getElementById("regis");
            var z = document.getElementById("caja");
            var textcolor1=document.getElementById("log");
            var textcolor2=document.getElementById("reg");
            textcolor1.style.color="#1C1678";
            textcolor2.style.color="#A3FFD6";

            function registrarvai()
            {
            x.style.left = "-150%";
            y.style.left = "0";
            z.style.left = "50%";
            textcolor2.style.color="#1C1678";
            textcolor1.style.color="#A3FFD6";
            }
            function loginvai()
            {
            x.style.left = "0";
            y.style.left = "150%";
            z.style.left = "0";
            textcolor2.style.color="#A3FFD6";
            textcolor1.style.color="#1C1678";
            }
        </script>
    </body>
</html>
