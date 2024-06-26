<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Lista de juegos</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>
    <body>
        <!-- Incluye el menú -->
        <?php include("menu/admin.html") ?>
        <!-- Una tabla llena de todos los juegos almacenados en la base de datos -->
        <div class="container">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-8"><h2>Listado de Juegos</h2></div>

                    </div>
                </div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Fecha de lanzamiento</th>
                            <th>Descripcion</th>
                            <th>Consola</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>    
                        <?php
                            // Incluye las funciones
                            include("logica/database.php");
                            $juegos = new Database();
                            $listado = $juegos->mostrarJuegos();
                            //`id`, `nombre`, `fechalanzamiento`, `descripcion`, `consola`
                            // Este while se encarga de que por cada registro en la BD halla una fila con toda la información de ese registro
                            while($row = mysqli_fetch_object($listado)){
                                $id = $row->id;
                                $nombre = $row->nombre;
                                $fechalanzamiento = $row->fechalanzamiento;
                                $descricpion = $row->descripcion;
                                $consola = $row->consola;
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
                                            echo $fechalanzamiento;
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            echo $descricpion;
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            echo $consola;
                                        ?>
                                    </td>
                                    <td>
                                        <!-- Unos simbolitos que te llevan a modificar el juego -->
                                        <a href="modificarJuego.php?id=<?php echo $id; ?>&mod">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                            </svg> Editar
                                        </a>
                                        <a href="modificarJuego.php?id=<?php echo $id; ?>&del">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                                <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5"/>
                                            </svg> Borrar
                                        </a>
                                    </td>
                                </tr>

                                <?php
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>     
    </body>
</html>
