<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="assets/style.css">
        <script src="https://kit.fontawesome.com/f5052dcd71.js" crossorigin="anonymous"></script>
        <title>Biblioteca Virtual - Libros</title>
    </head>
    <body>
        <?php
            // Incluye el menú y las funciones
            include('assets/menu.php');
            include('assets/vars.php');
            $aI = new Database();
            $sesion = $aI->login();
        ?>
        <!-- Formulario para registrar un nuevo libro, cuya información es enviada al catálogo para que allí se lleve a cabo el registro -->
        <article class="addLibro">
            <h1 id="addBook">Agregar Libro</h1>
            <main>
                <form action="catalogo.php" method="POST">
                    <label for="titulo">Título:</label>
                    <input type="text" name="titulo" id="titulo" required="">

                    <label for="autor">Autor/a:</label>
                    <input type="text" name="autor" id="autor" required="">

                    <label for="editorial">Editorial:</label>
                    <input type="text" name="editorial" id="editorial" required="">

                    <label for="categoria">Categoría:</label>
                    <input type="text" name="categoria" id="categoria" required="">

                    <label for="cantidad">Cantidad:</label>
                    <input type="number" name="cantidad" id="cantidad" required="">

                    <a class="submit" href="catalogo.php">Regresar</a>
                    <button type="submit" class="submit" name="add">Añadir Libro</button>
                </form>
            </main>
        </article>
    </body>
</html>
