<!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="assets/style.css">
        <script src="https://kit.fontawesome.com/f5052dcd71.js" crossorigin="anonymous"></script>
        <title>Biblioteca Virtual - Empleados</title>
    </head>
    <body>
        <?php
            include('assets/menu.php');
            include('assets/vars.php');
            $empleados = new Database();
            $sesion = $empleados->login();
            
            if(isset($_POST) && !empty($_POST)){
                $nombre = $empleados->sanitize($_POST["nombre"]);
                $apellido = $empleados->sanitize($_POST["apellido"]);
                $correo = $empleados->sanitize($_POST["correo"]);
                $dui = $empleados->sanitize($_POST["dui"]);
                $telefono = $empleados->sanitize($_POST["telefono"]);
                $contra = $empleados->sanitize($_POST["pass"]);
                $admin = $empleados->sanitize($_POST["status"]);
                $empleado = true;

                if (isset($_POST["add"])) {
                    $res = $empleados->anadirUsuario($nombre, $apellido, $correo, $dui, $telefono, $contra, $empleado, $admin);

                    if ($res) {
                        $mensaje = "<script>alert('Usuario empleado $nombre registrado');window.location='empleados.php'</script>";
                    } else {
                        $mensaje = "<script>alert('ERROR: No se pudo añadir al usuario empleado $nombre');window.location='empleados.php'</script>";
                    }

                } else if (isset($_POST["mod"])) {
                    $res = $empleados->modificarUsuario($id, $nombre, $apellido, $correo, $dui, $telefono, $contra, $empleado, $admin);

                    if ($res) {
                        $mensaje = "<script>alert('La cuenta del usuario empleado $nombre ha sido modificada');window.location='empleados.php'</script>";
                    } else {
                        $mensaje = "<script>alert('ERROR: No se ha podido modificar la cuenta del usuario empleado $nombre');window.location='empleados.php'</script>";
                    }
                    
                } else if (isset($_POST["del"])) {
                    $res = $empleados->eliminarUsuario($id);

                    if ($res) {
                        $mensaje = "<script>alert('La cuenta del usuario empleado $nombre ha sido eliminada');window.location='empleados.php'</script>";
                    } else {
                        $mensaje = "<script>alert('ERROR: No se ha podido eliminar la cuenta del usuario empleado $nombre');window.location='empleados.php'</script>";
                    }
                }

                echo $mensaje;
            }
        ?>
        <article class="empleados">
            <h1 id="Empleados">Lista de Empleados</h1>
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
                            <th>Estatus</th>
                            <th>Modificar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $lista = $empleados->mostrarElementos('usuarios');
                            while($row = mysqli_fetch_object($lista)){
                                $confirm = $row->empleado;

                                if ($confirm) {
                                    $id = $row->ID;                                
                                    $nombre = $row->nombre;                                
                                    $apellido = $row->apellido;
                                    $telefono = $row->telefono;
                                    $dui = $row->DUI;
                                    $correo = $row->correoElectronico;
                                    $estatus = $row->admin;
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
                                                echo $telefono;
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                                echo $dui;
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                                echo $correo;
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                                if($estatus){
                                                    echo "Administrador";
                                                } else if (!$estatus){
                                                    echo "Empleado";
                                                }
                                            ?>
                                        </td>
                                        <td>
                                            <a class="boton" href="modificarEmpleado.php?id=<?php echo $id; ?>&mod"><i class="fa-regular fa-pen-to-square"></i></a>
                                            &ensp;
                                            <a class="boton" href="modificarEmpleado.php?id=<?php echo $id; ?>&del"><i class="fa-regular fa-trash-can"></i></a>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                        ?>
                        <tr>
                            <td colspan="8">
                                <a class="add" href="agregarEmpleado.php">+ Añadir un nuevo empleado.</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </main>
        </article>
    </body>
</html>
