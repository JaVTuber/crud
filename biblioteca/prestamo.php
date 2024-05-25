<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="assets/style.css">
        <script src="https://kit.fontawesome.com/f5052dcd71.js" crossorigin="anonymous"></script>
        <title>Biblioteca Virtual - Préstamos</title>
    </head>
    <body>
        <?php
            // Añade el menú y las funciones
            include('assets/menu.php');
            include('assets/vars.php');
            $list = new Database();
            $sesion = $list->login();
            ?>
            <article class="prestamo">
                <?php
                    // Si el formulario de préstamos ya está lleno, recibe la cantidad de libros que se van a pedir
                    if (!empty($_POST) && isset($_POST["cantidadLibro"])) {
                        $cant = $list->sanitize($_POST["cantidadLibro"]);
                        $idC = $list->sanitize($_POST["idCliente"]);
                        $date = $list->sanitize($_POST["fecha"]);
                        ?>
                        <h1 id="Prestamo2">Libros</h1>
                        <main>
                            <form action="index.php" method="post">
                                <?php
                                // Y dependiendo de la cantidad de libros que halla, pondrá en pantalla un input y un label por libro que se pedirá
                                for ($inp = 1; $inp <= $cant; $inp++) {
                                    ?>
                                    <label for='libro<?php echo $inp; ?>'>Libro #<?php echo $inp; ?>:</label>
                                    <select name='libro<?php echo $inp; ?>' id='libro<?php echo $inp; ?>'>
                                        <?php
                                        $opcion = $list->mostrarElementos('libro');
                                        while ($row = mysqli_fetch_object($opcion)) {
                                            ?>
                                            <option value="<?php echo $row->ISBN;?>"><?php echo $row->titulo;?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                    <?php
                                }
                                ?>
                                <!-- Se envía la cantidad de libros que se pidieron, el ID del cliente y la fecha en la que se enviarán los libros pq nos servirán más adelante -->
                                <input type="number" style="display: none;"  name="cant" id="cant" value="<?php echo $cant; ?>">
                                <input type="number" style="display: none;"  name="idC" id="idC" value="<?php echo $idC; ?>">
                                <input type="date" style="display: none;"  name="date" id="date" value="<?php echo $date; ?>">
                                <br><br>
                                <a href="prestamo.php" class="submit">Regresar</a>
                                <button type="submit" class="submit">Solicitar Préstamo</button>
                            </form>
                        </main>
                        <?php
                    } else {
                        ?>
                        <h1 id="Prestamo1">Préstamo</h1>
                        <main>
                            <form action="prestamo.php" method="POST">
                                <label for="idCliente">ID de Cliente:</label>
                                <input type="number" id="idCliente" name="idCliente" required="">

                                <label for="fecha">Fecha del préstamo:</label>
                                <input type="date" name="fecha" id="fecha">

                                <label for="cantidadLibro">Libros a solicitar:</label>
                                <input type="number" name="cantidadLibro" id="cantidadLibro">

                                <a href="index.php" class="submit">Regresar</a>
                                <button type="submit" class="submit">Elegir libros</button>
                            </form>
                        </main>
                        <?php
                    }
                ?>
            </article>
            <?php
        ?>
        
    </body>
</html>
