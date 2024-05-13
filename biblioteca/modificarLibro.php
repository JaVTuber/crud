<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="assets/style.css">
        <script src="https://kit.fontawesome.com/f5052dcd71.js" crossorigin="anonymous"></script>
        <title>Biblioteca Virtual - libros</title>
    </head>
    <body>
        <?php
            // Incluye el menú y las funciones
            include('assets/menu.php');
            $libros = new Database();
            $sesion = $libros->login();

            if (isset($_GET["id"]) && (isset($_GET["mod"]) || isset($_GET["del"]))) {
                $id = $libros->sanitize($_GET["id"]);
                $res = $libros->buscarElemento('empleado','ID', $id);

                if ($res) {
                    if (isset($_GET["mod"])) {
                        ?>
                        <article class="modLibro">
                            <h1>Modificar Cuenta del Empleado</h1>
                            <main>
                                <form action="catalogo.php" method="POST">
                                    <label for="isbn">ISBN:</label>
                                    <input type="number" name="isbn" id="isbn" readonly="" value="<?php echo $res->ID; ?>">

                                    <label for="nombre">Nombre:</label>
                                    <input type="text" name="nombre" id="nombre" required="" value="<?php echo $res->nombre; ?>">

                                    <label for="apellido">Apellido:</label>
                                    <input type="text" name="apellido" id="apellido" required="" value="<?php echo $res->apellido; ?>">

                                    <label for="correo">Correo electrónico:</label>
                                    <input type="email" name="correo" id="correo" required="" value="<?php echo $res->correoElectronico; ?>">

                                    <label for="dui">DUI:</label>
                                    <input type="number" name="dui" id="dui" required="" value="<?php echo $res->DUI; ?>">

                                    <label for="telefono">Número de teléfono:</label>
                                    <input type="number" name="telefono" id="telefono" required="" value="<?php echo $res->telefono; ?>">

                                    <label for="pass">Contraseña:</label>
                                    <input type="text" name="pass" id="pass" required="" value="<?php echo $res->contrasena; ?>">

                                    <label for="status">Estatus:</label>
                                    <select name="status" id="status">
                                        <option value="false">Empleado</option>
                                        <option value="true">Administrador</option>
                                    </select>

                                    <a class="submit" href="catalogo.php">Regresar</a>
                                    <button type="submit" id="mod" name="mod" class="submit">Modificar Empleado</button>
                                </form>
                            </main>
                        </article>
                        <?php
                    } else if (isset($_GET["del"])) {
                        ?>
                        <article class="delLibro">
                            <h1>Eliminar Cuenta del Empleado</h1>
                            <main>
                                <form action="catalogo.php" method="POST">
                                    <label for="isbn">ISBN:</label>
                                    <input type="number" name="isbn" id="isbn" disabled="" value="<?php echo $res->ID; ?>">

                                    <label for="nombre">Nombre:</label>
                                    <input type="text" name="nombre" id="nombre" disabled="" value="<?php echo $res->nombre; ?>">

                                    <label for="apellido">Apellido:</label>
                                    <input type="text" name="apellido" id="apellido" disabled="" value="<?php echo $res->apellido; ?>">

                                    <label for="correo">Correo electrónico:</label>
                                    <input type="email" name="correo" id="correo" disabled="" value="<?php echo $res->correoElectronico; ?>">

                                    <label for="dui">DUI:</label>
                                    <input type="number" name="dui" id="dui" disabled="" value="<?php echo $res->DUI; ?>">

                                    <label for="telefono">Número de teléfono:</label>
                                    <input type="number" name="telefono" id="telefono" disabled="" value="<?php echo $res->telefono; ?>">

                                    <label for="pass">Contraseña:</label>
                                    <input type="text" name="pass" id="pass" disabled="" value="<?php echo $res->contrasena; ?>">

                                    <label for="delete">ADVERTENCIA: ¿Estás seguro de borrar al libro <?php echo $nombre; ?>? Esta acción no se puede deshacer</label>
                                    <a class="submit" href="catalogo.php">No, regresar</a>
                                    <button type="submit" id="delete" name="delete" class="submit">Sí, eliminar empleado</button>
                                </form>
                            </main>
                        </article>
                        <?php
                    }
                }
            }
        ?>
    </body>
</html>
