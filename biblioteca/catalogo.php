<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="assets/style.css">
        <script src="https://kit.fontawesome.com/f5052dcd71.js" crossorigin="anonymous"></script>
        <title>Biblioteca Virtual - Catálogo</title>
    </head>
    <body>
        <?php
            // Incluye el menú y las funciones
            include('assets/menu.php');
            include('assets/vars.php');
            $libros = new Database();
            $sesion = $libros->login();

            if(isset($_POST) && !empty($_POST)){
                $titulo = $libros->sanitize($_POST["titulo"]);
                $autor = $libros->sanitize($_POST["autor"]);
                $editorial = $libros->sanitize($_POST["editorial"]);
                $categoria = $libros->sanitize($_POST["categoria"]);
                $cantidad = $libros->sanitize($_POST["cantidad"]);

                if (isset($_POST["add"])) {
                    $res = $libros->anadirLibro($titulo, $autor, $editorial, $categoria, $cantidad);

                    if ($res) {
                        $mensaje = "<script>alert('Libro $titulo registrado');window.location='catalogo.php'</script>";
                    } else {
                        $mensaje = "<script>alert('ERROR: No se pudo añadir al libro $titulo');window.location='catalogo.php'</script>";
                    }

                } else if (isset($_POST["mod"])) {
                    $res = $libros->modificarLibro($isbn, $titulo, $autor, $editorial, $categoria, $cantidad);

                    if ($res) {
                        $mensaje = "<script>alert('El libro $titulo ha sido modificado');window.location='catalogo.php'</script>";
                    } else {
                        $mensaje = "<script>alert('ERROR: No se ha podido modificar al libro $titulo');window.location='catalogo.php'</script>";
                    }
                    
                } else if (isset($_POST["del"])) {
                    $res = $libros->eliminarLibro($isbn);

                    if ($res) {
                        $mensaje = "<script>alert('El libro $titulo ha sido eliminado');window.location='catalogo.php'</script>";
                    } else {
                        $mensaje = "<script>alert('ERROR: No se ha podido eliminar el libro $titulo');window.location='catalogo.php'</script>";
                    }
                }

                echo $mensaje;
            }
        ?>
        <article class="libros">
            <h1 id="Catalogo">Catálogo de Libros Disponibles</h1>
            <main>
                <table>
                    <thead>
                        <tr>
                            <?php
                                if($_SESSION['emp'] == true) {
                                    echo "<th>ISBN</th>";
                                }
                            ?>
                            <th>Título</th>
                            <th>Autor</th>
                            <th>Categoría</th>
                            <th>Editorial</th>
                            <?php
                                if($_SESSION['emp'] == true){
                                    ?>
                                    <th>Cantidad</th>
                                    <th>Modificar</th>
                                    <?php
                                }
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $lista = $libros->mostrarElementos('libro');
                            while($row = mysqli_fetch_object($lista)){
                                $isbn = $row->ISBN;
                                $titulo = $row->titulo;
                                $autor = $row->autor;
                                $categoria = $row->categoria;
                                $editorial = $row->editorial;
                                $cantidad = $row->ejemplaresDisponibles;
                                ?>
                                <tr>
                                    <?php 
                                        if ($_SESSION['emp'] == true) {
                                            echo "<td>$isbn</td>";
                                        }
                                    ?>
                                    <td>
                                        <?php
                                            echo $titulo;
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            echo $autor;
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            echo $categoria;
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            echo $editorial;
                                        ?>
                                    </td>
                                    <?php
                                        if ($_SESSION['emp'] == true) {
                                            echo '<td>' . $cantidad . '</td><td><a class="boton" href="modificarLibro.php?isbn=' . $isbn . '&mod"><i class="fa-regular fa-pen-to-square"></i></a>&ensp;<a class="boton" href="modificarLibro.php?isbn=' . $isbn . '&del"><i class="fa-regular fa-trash-can"></i></a></td>';
                                        }
                                    ?>
                                </tr>
                                <?php
                            }

                            if ($_SESSION['emp'] == true) {
                                echo '<tr><td colspan="8"><a class="add" href="agregarLibro.php">+ Añadir un nuevo libro.</a></td></tr>';
                            }
                        ?>
                    </tbody>
                </table>
            </main>
        </article>
    </body>
</html>
