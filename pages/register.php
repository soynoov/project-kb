<?php
//Conexion con la base de datos
$cadena_conexion = "mysql:dbname=proyecto_ki;host=localhost";
$root = "root";
$key = "";

try {
    $db = new PDO($cadena_conexion, $root, $key);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $nombre = $_POST["nombre"];
        $correo = $_POST["correo"];
        $direccion = $_POST["direccion"];
        $clave = $_POST["clave"];

        if (empty($correo) || empty($clave) || empty($nombre) || empty($direccion)) {
            echo "Es necesario rellenar todos los campos";
        } else {
            $data = $db->query("INSERT INTO usuario(nombre, correo, direccion, clave) VALUES ('$nombre', '$correo', '$direccion', '$clave')");
            header("Location:../index.php?check=true");

        }

    }


} catch (PDOException $e) {
    echo "Error con la base de datos: " . $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
    <title>| Kebab</title>
</head>

<body class="register">

    <form action="" method="post">

        <h3>Crear Cuenta</h3>
        <input type="text" name="nombre" placeholder="Nombre" value="">
        <input type="text" name="correo" placeholder="Correo" value="">
        <input type="text" name="direccion" placeholder="Dirección" value="">
        <input type="password" name="clave" placeholder="Clave">
        <input type="submit" value="Entrar">

        <p>¿Ya tienes cuenta?</p>

        <a href="../index.php">Iniciar Sesión</a>
        <a href="/menu.php">Entrar como Invitado</a>

    </form>

</body>

</html>