<?php
session_start();
include('conexion.php');
if (isset($_SESSION['usuarioingresando'])) {
    $usuarioingresado = $_SESSION['usuarioingresando'];
    $buscandousu = mysqli_query($conn, "SELECT * FROM usuarios WHERE correo = '" . $usuarioingresado . "'");
    $mostrar = mysqli_fetch_array($buscandousu);
} else {
    header('location: index.php');
}

?>

<html>

<head>
    <title>CRUD</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="BarraLateral">

        <ul>
            <li><a href="tabla_productos.php">• Productos</a></li>
            <li><a href="categoria_tabla.php">• Categoría</a></li>
            <li><a href="cerrar_sesion.php">• Cerrar sesión</a></li>
        </ul>
        <hr>
    </div>
</body>

</html>