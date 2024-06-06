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

            if (!empty($_POST) && isset($_POST['prestamo'])) {
                $id = $list->sanitize($_POST['idCliente']);
                $fechaI = $list->sanitize($_POST['fecha']);
                $fechaF = date('Y-m-d', strtotime($fechaI . '+1 Month'));
                $cantidad = $list->sanitize($_POST['itemCount']);

                $prestamoUno = $list->prestamo($id, $fechaI, $fechaF, $cantidad);

                $books = $list->mostrarElementos('libro');
                $prestamos = $list->mostrarElementos('prestamo');
                $idP = array();
                $idC = array();

                while ($row = mysqli_fetch_object($prestamos)) {
                    $idP[] = $row->ID;
                    $idC[] = $row->codigoUsuario;
                }

                for ($i=0; $i < count($idP); $i++) { 
                    if ($id == $idC[$i]) {
                        while ($row = mysqli_fetch_object($books)) {
                            $isbn = $row->ISBN;
                            $cant = $row->ejemplaresDisponibles . -1;

                            if (isset($_POST["$isbn"])) {
                                $prestamoDos = $list->prestamoCant($idP[$i], $isbn);
                                $restarLibro = $list->libroPrestamo($isbn, $cant);
                            }
                        }
                    }
                }

                echo "<script>alert('Préstamo registrado, se le enviará la cantidad de $cantidad libro(s) el $fechaI, no olvide entregarlos el $fechaF');window.location='prestamo.php'</script>";

                $asunto = "¡Gracias por haber realizado su préstamo en La Biblioteca Virtual" . "\n" . "Usted, " . $_SESSION['usuario'] . " ha realizado un préstamo de $cantidad libro(s), se le entregará(n) el $fechaI y no olvide regresarlos el $fechaF" . "\n\n" . "- El equipo de La Biblioteca Virtual";

                $log = $list->buscarElemento('usuarios', 'ID', $_SESSION['id']);

                mail($log->correoElectronico, '¡Préstamo realizado!', $asunto, $_SESSION['header']);
            }
        ?>
        <article class="Prestamo">
            <h1 id="Prestamo">Préstamo</h1>
            <main>
                <form action="prestamo.php" method="POST">
                    <label for="idCliente">ID de Cliente:</label>
                    <input type="number" id="idCliente" name="idCliente" required="" readonly="" value="<?php echo $_SESSION['id']; ?>">

                    <label for="fecha">Fecha del préstamo:</label>
                    <input type="date" name="fecha" id="fecha" min="<?php echo date("Y-m-d"); ?>">

                    <label for="itemCount">Cantidad de libros a prestar:</label>
                    <input type="number" name="itemCount" id="itemCount" min="1" required="">

                    <label>Libros a solicitar:</label>
                    <?php
                        $libros = $list->mostrarElementos('libro');
                        while($row = mysqli_fetch_object($libros)){
                            $isbn = $row->ISBN;
                            $titulo = $row->titulo;
                            $autor = $row-> autor;
                            $cantidad = $row->ejemplaresDisponibles;

                            if ($cantidad != 0) {
                                echo "<input type='checkbox' class='itemCheckbox' name='$isbn' id='$isbn'>&quot;$titulo&quot; por $autor <br>";
                            }
                        }
                    ?>

                    <br>
                    
                    <button type="submit" class="submit" name="prestamo">Solicitar Préstamo</button>
                </form>
            </main>
        </article>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const itemCountInput = document.getElementById('itemCount');
                const checkboxes = document.querySelectorAll('.itemCheckbox');

                itemCountInput.addEventListener('input', updateCheckboxState);
                checkboxes.forEach(checkbox => checkbox.addEventListener('change', handleCheckboxChange));

                function updateCheckboxState() {
                    const itemCount = parseInt(itemCountInput.value, 10);
                    const selectedCount = document.querySelectorAll('.itemCheckbox:checked').length;

                    checkboxes.forEach(checkbox => {
                        if (!checkbox.checked) {
                            checkbox.disabled = selectedCount >= itemCount;
                        }
                    });
                }

                function handleCheckboxChange() {
                    updateCheckboxState();
                }
            });

        </script>
    </body>
</html>
