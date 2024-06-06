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

            h3.hecho {
                display: inline;
                background-color: var(--navy);
                padding: 0.75%;
                border-radius: 15px;
                color: var(--clearColor);
                font-weight: normal;
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
                    $presDevuelto = $rowUno->devuelto;
                    $confirmado = $rowUno->confirmado;
                    $todoDevuelto = $prest->verificarLibro($numPres, $cantidad);

                    if (!isset($recordatorio)) {
                        if ($fechaDos == date('Y-m-d')) {
                            $asunto = "Hoy es tu último día para devolver los libros que te prestamos en el préstamo No. $numPres, puedes revisar tus libros pendientes en el menú de préstamo de nuestro sitio web." . "\n\n" . "- El equipo de La Biblioteca Virtual";

                            $log = $list->buscarElemento('usuarios', 'ID', $_SESSION['id']);

                            mail($log->correoElectronico, '¡Recordatorio!', $asunto, $_SESSION['header']);
                        }

                        $recordatorio = true;
                    }

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
                                            $aidi = $rowDos->codigoLibro . strval($numPres);
                                            $elLibro = $prest->buscarElementos('libro', 'ISBN', $rowDos->codigoLibro);
                                            $nombreLibro = mysqli_fetch_object($elLibro);
                                            $titulo = $nombreLibro->titulo;
                                            $autor = $nombreLibro->autor;
                                            $cant = $nombreLibro->ejemplaresDisponibles;

                                            if (!empty($_POST) ) {
                                                if (isset($_POST[$numPres . '0']) && isset($_POST[$aidi])) {
                                                    $libroDevueltoUno = $prest->devolverLibro($rowDos->codigoLibro, $numPres);
                                                    $libroDevueltoDos = $prest->libroPrestamo($rowDos->codigoLibro, $cant . +1);
                                                } else if (isset($_POST[$numPres . '1'])) {
                                                    $prestamoDevuelto = $prest->devolverPrestamo($numPres);
    
                                                    $asunto = "Muchas gracias " . $_SESSION['usuario'] . " por haber devuelto todos los libros del préstamo No. $numPres:";
    
                                                    while ($rowTres = mysqli_fetch_object($libros)) {
                                                        $rowCuatro = $prest->buscarElementos('libro', 'ISBN', $rowTres->codigoLibro);
                                                        $elementos = mysqli_fetch_object($rowCuatro);
                                                        $nmb = $elementos->titulo;
                                                        $atr = $elementos->autor;

                                                        $asunto .= "\n" . "- '$nmb', de $atr.";
                                                    }

                                                    $asunto .= "\n\n" . "- El equipo de La Biblioteca Virtual";

                                                    $log = $prest->buscarElemento('usuarios', 'ID', $_SESSION['id']);
    
                                                    mail($log->correoElectronico, '!Préstamo devuelto!', $asunto, $_SESSION['header']);
                                                }
                                            }

                                            $yaDevuelto = $rowDos->devuelto;
                                            ?> 
                                            <li>&quot<?php echo $titulo; ?>&quot por <?php echo $autor; ?><input type='checkbox' name='<?php echo $aidi; ?>' id='<?php echo $aidi; ?>' <?php if (($_SESSION['id'] != $idUsuario) || ($yaDevuelto == true)) { echo "disabled=''"; } if ($yaDevuelto == true) { echo "checked=''"; } ?>></li>
                                            <?php
                                        }
                                    ?>
                                </ul>
                                <br>
                                <?php
                                    if ($confirmado == true) {
                                        echo "<h3 class='hecho'>Préstamo completado.</h3>";
                                    } else if ($confirmado != true) {
                                        if ($_SESSION['id'] == $idUsuario) {
                                            ?>
                                            <button type='submit' class='submit' id='<?php echo $numPres . '0'; ?>' name='<?php echo $numPres . '0'; ?>' <?php if($presDevuelto == true) { echo "disabled=''"; } ?>>Devolver libro</button>
                                            <?php
                                        } else if ($_SESSION['id'] != $idUsuario) {
                                            ?>
                                            <button type='submit' class='submit' name='<?php echo $numPres . '1'; ?>' id='<?php echo $numPres . '1'; ?>' <?php if($presDevuelto == false) { echo "disabled=''"; } ?>>Confirmar devolución</button>
                                            <?php
                                        }
                                    }
                                ?>
                            </form>
                            <br>
                            <hr>
                            <br>
                        </div>
                        <?php
                    } else if ($_SESSION['emp'] != true) {
                        if ($idUsuario == $_SESSION['id']) {
                            ?>
                            <div class="elementoPrestamo">
                                <h2 class="titulo">Préstamo #<?php echo $numPres; ?></h2>
                                <p class="line"><b>Fecha de entrega:</b> <?php echo $fechaUno; ?></p>
                                <p class="line"><b>Fecha de devolución:</b> <?php echo $fechaDos; ?></p>
                                <p><b>Libros prestados:</b></p>
                                <form action="prestamo.php" method="POST">
                                    <ul>
                                        <?php
                                            while ($rowDos = mysqli_fetch_object($libros)) {
                                                if (isset($_POST[$numPres . '0']) && isset($_POST[$aidi])) {
                                                    $libroDevueltoUno = $prest->devolverLibro($rowDos->codigoLibro, $numPres);
                                                    $libroDevueltoDos = $prest->libroPrestamo($rowDos->codigoLibro, $cant . +1);
                                                } else if (isset($_POST[$numPres . '1'])) {
                                                    $prestamoDevuelto = $prest->devolverPrestamo($numPres);
    
                                                    $asunto = "Muchas gracias " . $_SESSION['usuario'] . " por haber devuelto todos los libros del préstamo No. $numPres:";
    
                                                    while ($rowTres = mysqli_fetch_object($libros)) {
                                                        $rowCuatro = $prest->buscarElementos('libro', 'ISBN', $rowTres->codigoLibro);
                                                        $elementos = mysqli_fetch_object($rowCuatro);
                                                        $nmb = $elementos->titulo;
                                                        $atr = $elementos->autor;

                                                        $asunto .= "\n" . "- '$nmb', de $atr.";
                                                    }

                                                    $asunto .= "\n\n" . "- El equipo de La Biblioteca Virtual";

                                                    $log = $prest->buscarElemento('usuarios', 'ID', $_SESSION['id']);
    
                                                    mail($log->correoElectronico, '!Préstamo devuelto!', $asunto, $_SESSION['header']);
                                                }

                                                $aidi = $rowDos->codigoLibro . strval($numPres);
                                                $yaDevuelto = $rowDos->devuelto;
                                                $elLibro = $prest->buscarElementos('libro', 'ISBN', $rowDos->codigoLibro);
                                                $nombreLibro = mysqli_fetch_object($elLibro);
                                                $titulo = $nombreLibro->titulo;
                                                $autor = $nombreLibro->autor;
                                                ?> 
                                                <li>&quot<?php echo $titulo; ?>&quot por <?php echo $autor; ?><input type='checkbox' name='<?php echo $aidi; ?>' id='<?php echo $aidi; ?>' <?php if (($_SESSION['id'] != $idUsuario) || ($yaDevuelto == true)) { echo "disabled=''"; } if ($yaDevuelto == true) { echo "checked=''"; } ?>></li>
                                                <?php
                                            }

                                            if ($confirmado == true) {
                                                echo "<h3 class='hecho'>Préstamo completado.</h3>";
                                            } else if ($confirmado != true) {
                                                ?>
                                                <br>
                                                <button type='submit' class='submit' id='<?php echo $numPres . '0'; ?>' name='<?php echo $numPres . '0'; ?>' <?php if($presDevuelto == true) { echo "disabled=''"; } ?>>Devolver libro</button>
                                                <?php
                                            }
                                        ?>
                                    </ul>
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
