<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="assets/style.css">
        <style>
            .elementoPrestamo {
                /* border: #f00 solid 2.5px; */

                background-color: var(--clearColor);
                padding: 0;
                border-radius: 50px;
            }

            p, h2, h3, ul {
                margin: 0.5%;
            }

            p.line {
                display: inline-block;
            }

            form.form {
                padding: 0;
                margin: 0;
                background-color: var(--clearColor);
                box-shadow: none;
            }
        </style>
        <title>Biblioteca Virtual - Préstamos</title>
    </head>
    <body>
        <?php
            include('assets/menu.php');
            include('assets/vars.php');
            $prest = new Database();
            $login = $prest->login();
        ?>
        <article class="listaPrestamos">
            <h1 id="ListaPrestamos">Préstamos</h1>
            <?php
                $prestamos = $prest->mostrarElementos('prestamo');

                while ($rowUno = mysqli_fetch_object($prestamos)) {
                    $numPres = $rowUno->ID;
                    $fechaUno = $rowUno->fechaPrestamo;
                    $fechaDos = $rowUno->fechaDevolucion;
                    $idUsuario = $rowUno->codigoUsuario;
                    $cantidad = $rowUno->cantidadLibro;
                    $libros = $prest->buscarElementos('librosprestados', 'codigoPrestamo', $numPres);
                    $usuarios = $prest->buscarElementos('usuarios', 'ID', $idUsuario);
                    $nombreUsuario = mysqli_fetch_object($usuarios);
                    $devuelto = $rowUno->devuelto;
                    $confirmado = $rowUno->confirmado;

                    

                    if ($_SESSION['emp'] == true) {
                        ?>
                        <div class="elementoPrestamo">
                            <h2 class="titulo">Préstamo #<?php echo $numPres; ?></h2>
                            <?php
                                if ($_SESSION['emp'] == true) {
                                    echo "<h3 class='nom'>$nombreUsuario->nombre</h3>";
                                }
                            ?>
                            <p class="line"><b>Fecha de entrega:</b> <?php echo $fechaUno; ?></p>
                            <p class="line"><b>Fecha de devolución:</b> <?php echo $fechaDos; ?></p>
                            <p><b>Libros prestados:</b></p>
                            <form action="prestamo.php" method="POST" class="form">
                                <ul>
                                    <?php
                                        while ($rowDos = mysqli_fetch_object($libros)) {
                                            if (!empty($_POST)) {
                                                if (isset($_POST[$numPres . '0'])) {
                                                    $libroPrest = $prest->buscarElementos('librosprestados', 'codigoLibro', $rowDos->codigoLibro);
                                                    
                                                    while ($rowTres = mysqli_fetch_object($libroPrest)) {
                                                        $codLib = $rowTres->codigoLibro;

                                                        if (isset($_POST[$codLib . '0'])) {
                                                            $devolver = $prest->modificar('librosprestados', 'devuelto', true, 'codigoLibro', $codLib);
                                                            if ($codLib->devuelto == true) {
                                                                $devolverFin = $prest->modificar('prestamo', 'devuelto', true, 'ID', $numPres);
                                                            }
                                                        }
                                                    }
                                                } else if (isset($_POST[$numPres - '1'])) {
                                                    $confirmar = $prest->modificar('prestamo', 'confirmado', true, 'ID', $numPres);
                                                }
                                            }

                                            $aidi = $rowDos->codigoLibro . '0';
                                            $elLibro = $prest->buscarElementos('libro', 'ISBN', $rowDos->codigoLibro);
                                            $nombreLibro = mysqli_fetch_object($elLibro);
                                            $titulo = $nombreLibro->titulo;
                                            $autor = $nombreLibro->autor;
                                            ?>
                                            <li>&quot<?php echo $titulo; ?>&quot por <?php echo $autor; ?><input type='checkbox' name='<?php echo $aidi; ?>' id='<?php echo $aidi; ?>' <?php if ($_SESSION['id'] != $idUsuario) { echo "disabled=''"; } ?>></li>
                                            <?php
                                        }
                                    ?>
                                </ul>
                                <br>
                                <?php
                                    if ($_SESSION['id'] == $idUsuario) {
                                        ?>
                                        <button type='submit' class='submit' id='<?php echo $numPres . '0'; ?>' name='<?php echo $numPres . '0'; ?>' <?php if($devuelto == true) { echo "disabled=''"; } ?>>Devolver libro</button>
                                        <?php
                                    } else if ($_SESSION['id'] != $idUsuario) {
                                        ?>
                                        <button type='button' class='submit' name='<?php echo $numPres . '1'; ?>' id='<?php echo $numPres . '1'; ?>' <?php if($devuelto == false) { echo "disabled=''"; } ?>>Confirmar devolución</button>
                                        <?php
                                    }
                                ?>
                            </form>
                            <br><br><br>
                            <hr>
                            <br>
                        </div>
                        <?php
                    } else if ($_SESSION['emp'] != true) {
                        if ($idUsuario == $_SESSION['id']) {
                            ?>
                            <div class="elementoPrestamo">
                                <h2 class="tit">Préstamo #<?php echo $numPres; ?></h2>
                                <p class="line"><b>Fecha de entrega:</b> <?php echo $fechaUno; ?></p>
                                <p class="line"><b>Fecha de devolución:</b> <?php echo $fechaDos; ?></p>
                                <p><b>Libros prestados:</b></p>
                                <form action="prestamo.php" method="POST">
                                    <ul>
                                        <?php
                                            while ($rowDos = mysqli_fetch_object($libros)) {
                                                $aidi = $rowDos->codigoLibro . '0';
                                                $elLibro = $prest->buscarElementos('libro', 'ISBN', $rowDos->codigoLibro);
                                                $nombreLibro = mysqli_fetch_object($elLibro);
                                                $titulo = $nombreLibro->titulo;
                                                $autor = $nombreLibro->autor;
                                                ?>
                                                <li>&quot<?php echo $titulo; ?>&quot por <?php echo $autor; ?><input type='checkbox' name='<?php echo $aidi; ?>' id='<?php echo $aidi; ?>'></li>
                                                <?php
                                            }
                                        ?>
                                    </ul>
                                    <br>
                                    <button type='submit' class='submit' id='<?php echo $numPres . '0'; ?>' name='<?php echo $numPres . '0'; ?>' <?php if($devuelto == true) { echo "disabled=''"; } ?>>Devolver libro</button>
                                </form>
                                <br><br><br>
                                <hr>
                                <br>
                            </div>
                            <?php
                        }
                    } else {
                        echo "Ha ocurrido un error, intente recargar la página.";
                    }
                }
            ?>
            <a style="font-size: 1.25em;" class="add" href="realizarPrestamo.php">+ Hacer un préstamo</a>
        </article>
    </body>
</html>
