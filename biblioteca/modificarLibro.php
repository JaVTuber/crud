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
            include('assets/vars.php');
            $libros = new Database();
            $sesion = $libros->login();

            if (isset($_GET["isbn"]) && (isset($_GET["mod"]) || isset($_GET["del"]))) {
                $isbn = $libros->sanitize($_GET["isbn"]);
                $res = $libros->buscarElemento('libro','ISBN', $isbn);

                if ($res) {
                    if (isset($_GET["mod"])) {
                        ?>
                        <article class="modLibro">
                            <h1>Modificar Cuenta del Empleado</h1>
                            <main>
                                <form action="catalogo.php" method="POST">
                                    <label for="isbn">ISBN:</label>
                                    <input type="number" name="isbn" id="isbn" readonly="" required="" value="<?php echo $res->ISBN; ?>">

                                    <label for="titulo">Título:</label>
                                    <input type="text" name="titulo" id="titulo" required="" value="<?php echo $res->titulo; ?>">

                                    <label for="autor">Autor:</label>
                                    <input type="text" name="autor" id="autor" required="" value="<?php echo $res->autor; ?>">

                                    <label for="editorial">Editorial:</label>
                                    <input type="text" name="editorial" id="editorial" required="" value="<?php echo $res->editorial; ?>">

                                    <label for="categoria">Categoría:</label>
                                    <input type="text" name="categoria" id="categoria" required="" value="<?php echo $res->categoria; ?>">

                                    <label for="cantidad">Cantidad:</label>
                                    <input type="number" name="cantidad" id="cantidad" required="" value="<?php echo $res->ejemplaresDisponibles ?>">

                                    <a class="submit" href="catalogo.php">Regresar</a>
                                    <button type="submit" id="mod" name="mod" class="submit">Modificar Libro</button>
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
                                    <input type="number" name="isbn" id="isbn" readonly="" required="" value="<?php echo $res->ISBN; ?>">

                                    <label for="titulo">Título:</label>
                                    <input type="text" name="titulo" id="titulo" readonly="" required="" value="<?php echo $res->titulo; ?>">

                                    <label for="autor">Autor:</label>
                                    <input type="text" name="autor" id="autor" readonly="" required="" value="<?php echo $res->autor; ?>">

                                    <label for="editorial">Editorial:</label>
                                    <input type="text" name="editorial" id="editorial" readonly="" required="" value="<?php echo $res->editorial; ?>">

                                    <label for="categoria">Categoría:</label>
                                    <input type="text" name="categoria" id="categoria" readonly="" required="" value="<?php echo $res->categoria; ?>">

                                    <label for="delete">ADVERTENCIA: ¿Estás seguro de borrar al libro <?php echo $res->titulo; ?>? Esta acción no se puede deshacer</label>
                                    <a class="submit" href="catalogo.php">No, regresar</a>
                                    <button type="submit" id="del" name="del" class="submit">Sí, eliminar libro</button>
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
