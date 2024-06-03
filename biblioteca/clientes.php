<!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="assets/style.css">
        <script src="https://kit.fontawesome.com/f5052dcd71.js" crossorigin="anonymous"></script>
        <title>Biblioteca Virtual - Clientes</title>
    </head>
    <body>
        <?php
            include('assets/menu.php');
            include('assets/vars.php');
            $clientes = new Database();
            $sesion = $clientes->login();

            if(isset($_POST) && !empty($_POST)){
                $id = $clientes->sanitize($_POST["id"]);
                $nombre = $clientes->sanitize($_POST["nombre"]);
                $apellido = $clientes->sanitize($_POST["apellido"]);
                $correo = $clientes->sanitize($_POST["correo"]);
                $dui = $clientes->sanitize($_POST["dui"]);
                $telefono = $clientes->sanitize($_POST["telefono"]);
                $contra = $clientes->sanitize($_POST["pass"]);
                $empleado = false;
                $admin = false;

                if (isset($_POST["add"])) {
                    $res = $clientes->anadirUsuario($nombre, $apellido, $correo, $dui, $telefono, $contra, $empleado, $admin);

                    if ($res) {
                        $mensaje = "<script>alert('Usuario cliente $nombre registrado');window.location='clientes.php'</script>";
                    } else {
                        $mensaje = "<script>alert('ERROR: No se pudo añadir al usuario cliente $nombre');window.location='clientes.php'</script>";
                    }

                } else if (isset($_POST["mod"])) {
                    $res = $clientes->modificarUsuario($id, $nombre, $apellido, $correo, $dui, $telefono, $contra, $empleado, $admin);

                    if ($res) {
                        $mensaje = "<script>alert('La cuenta del usuario cliente $nombre ha sido modificada');window.location='clientes.php'</script>";
                    } else {
                        $mensaje = "<script>alert('ERROR: No se ha podido modificar la cuenta del usuario cliente $nombre');window.location='clientes.php'</script>";
                    }
                    
                } else if (isset($_POST["del"])) {
                    $res = $clientes->eliminarUsuario($id);

                    if ($res) {
                        $mensaje = "<script>alert('La cuenta del usuario cliente $nombre ha sido eliminada');window.location='clientes.php'</script>";
                    } else {
                        $mensaje = "<script>alert('ERROR: No se ha podido eliminar la cuenta del usuario cliente $nombre');window.location='clientes.php'</script>";
                    }
                }

                echo $mensaje;
            }
        ?>
        <article class="clientes">
            <h1 id="Clientes">Listado de Clientes Registrados</h1>
            <main>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Teléfono</th>
                            <th>DUI</th>
                            <th>Correo Electrónico</th>
                            <th>Contraseña</th>
                            <th>Modificar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $lista = $clientes->mostrarElementos('usuarios');
                            while ($row = mysqli_fetch_object($lista)) {
                                $trabaja = $row->empleado;
                                $id = $row->ID;                                
                                $nombre = $row->nombre;
                                $apellido = $row->apellido;
                                $correo = $row->correoElectronico;
                                $dui = $row->DUI;
                                $telefono = $row->telefono;
                                $contraseña = $row->contrasena;    
                                
                                if ($trabaja == false) {
                                    ?>
                                    <tr>
                                        <td>
                                            <?php
                                                echo $id;
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                                echo $nombre;
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                                echo $apellido;
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                                echo $correo;
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                                echo $dui;
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                                echo $telefono;
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                                echo $contraseña;
                                            ?>
                                        </td>
                                        <td>
                                            <a class="boton" href="modificarCliente.php?id=<?php echo $id; ?>&mod"><i class="fa-regular fa-pen-to-square"></i></a>
                                            &ensp;
                                            <a class="boton" href="modificarCliente.php?id=<?php echo $id; ?>&del"><i class="fa-regular fa-trash-can"></i></a>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                        ?>
                        <tr>
                            <td colspan="8">
                                <a class="add" href="agregarCliente.php">+ Añadir un nuevo cliente.</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </main>
        </article>
    </body>
</html>
