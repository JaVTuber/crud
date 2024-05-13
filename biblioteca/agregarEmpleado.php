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
            // Incluye el menú y las funciones
            include('assets/menu.php');
            $aE = new Database();
            $sesion = $aE->login();
        ?>
        <!-- Formulario para registrar un nuevo empleado, cuya información es enviada a la lista de empleados para que allí se lleve a cabo el registro -->
        <article class="addEmpleado">
            <h1 id="addEmpleado">Añadir nuevo Empleado </h1>
            <main>
                <form action="empleados.php" method="POST">
                    <label for="nombre">Nombre:</label>
                    <input type="text" name="nombre" id="nombre" required="">

                    <label for="apellido">Apellido:</label>
                    <input type="text" name="apellido" id="apellido" required="">

                    <label for="correo">Correo electrónico:</label>
                    <input type="email" name="correo" id="correo" required="">

                    <label for="dui">DUI:</label>
                    <input type="number" name="dui" id="dui" required="">

                    <label for="telefono">Número de teléfono:</label>
                    <input type="number" name="telefono" id="telefono" required="">

                    <label for="pass">Contraseña:</label>
                    <input type="password" name="pass" id="pass" required="">

                    <label for="status">Estatus:</label>
                    <select name="status" id="status">
                        <option value="false">Empleado</option>
                        <option value="true">Administrador</option>
                    </select>

                    <a class="submit" href="empleados.php">Regresar</a>
                    <button type="submit" class="submit">Registrar Empleado</button>
                </form>
            </main>
        </article>
    </body>
</html>
