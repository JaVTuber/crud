<?php
    include('assets/menu.php');
    include('assets/vars.php');
    
    $login = new Database();

    if(!empty($_POST)) {
        $usuarios = $login->mostrarElementos('usuarios');
        $users = array();
        $passs = array();
        $isEmp = array();
        $isAdm = array();

        while ($row = mysqli_fetch_object($usuarios)) {
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

                if ($isEmp == true) {
                    $_SESSION['emp'] = true;

                    if ($isAdm == true) {
                        $_SESSION['adm'] = ($username == 'admin');
                    }
                }

                header('Location: index.php');
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            /* Variables */
            :root{
                --navy: #1C1678;
                --lightBlue: #c3ecff;
                --mint: #A3FFD6;
                --clearColor: #cfffe9;
            }

            /* Estilos del login */
            body{
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
                background-color: var(--navy);
            }

            div#center{
                width: 50%;
                margin: 5em auto;
                
            }

            h2{
                box-sizing: border-box;
                width: 55%;
                margin: 0.75em auto;
                padding: 15px;
                border-radius: 25px;
                background-color: var(--lightBlue);
                text-align: center;
                color: var(--navy);
                font-size: 2em;
            }

            form.log{
                padding: 25px 30px;
                border-radius: 25px;
                background-color: var(--mint);
            }

            label {
                display: block;
                margin-bottom: 5px;
                font-size: 1.4em;
                font-weight: bold;
            }

            input{
                width: calc(100% - 20px);
                padding: 10px;
                margin-top: 5px;
                margin-bottom: 15px;
                border: 1px solid #ccc;
                border-radius: 5px;
                box-sizing: border-box;
                font-size: 1em;
            }

            button  {
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

            button:hover {
                background-color: #ccc;
                color: black;
            }
        </style>
        <title>Inicio de Sesión</title>
    </head>
    <body>
        <div id="center">
            <div id="login">
                <h2>Inicio de Sesión</h2>
                <form class="log" method="POST" action="login.php">
                    <label for="username">Ingrese su nombre de usuario:</label>
                    <input type="text" name="username" placeholder="Usuario" required>

                    <br><br>

                    <label for="password">Ingrese su contraseña:</label>
                    <input type="password" name="password" placeholder="Contraseña" required>
                    
                    <button type="submit">Iniciar Sesión</button>
                </form>
                <?php if (isset($error)): ?>
                    <p style="color: red;"><?php echo $error; ?></p>
                <?php endif; ?>
            </div>
            <div id="register">

            </div>
        </div>
    </body>
</html>
