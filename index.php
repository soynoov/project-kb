<?php

//Conexion con la base de datos
$cadena_conexion = "mysql:dbname=proyecto_ki;host=localhost";
$root = "root";
$key = "";

try {

    $db = new PDO($cadena_conexion, $root, $key);

    //hacemos un metodo post para que recibamos los valores del formulario y transformarlos a valores
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $correo = $_POST["correo"];
        $clave = $_POST["clave"];

        $data = $db->query("SELECT * FROM usuario WHERE correo = '$correo' AND clave = '$clave'");
        $fetch = $data->fetch();

        if (empty($correo) && empty($clave)) {
            echo "Es necesario rellenar los campos";
        }

        //Buscamos en la base de datos los valores que queremos atraves de los valores obtenidos por el formulario
        if ($data->rowCount() == 0) {
            $error = true;
        } else {
            if ($_POST["correo"] == $fetch["correo"] and $_POST["clave"] == $fetch["clave"]) {
                session_start();
                $_SESSION["usuario"] = $fetch["id_usuario"];
                $_SESSION["nombreusu"] = $fetch["nombre"];
                header("Location:pages/menu.php?user=" . $fetch["id_usuario"]);
            } else {
                $user = $_POST["user"];
                $error = true;
            }
        }

        if (isset($error)) {
            echo "El correo y/o la contraseña son incorrectos.";
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
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
    <title>| Kebab</title>
</head>

<body class="login">

    <?php
    if (isset($_GET["check"])) {
        echo "<p id='check'>Te has registrado con éxito.</p>";
    }
    ?>

    <form action="" method="post">

        <h3>Iniciar Sesión</h3>

        <input type="text" name="correo" placeholder="Correo" value="">
        <input type="password" name="clave" placeholder="Clave">
        <input type="submit" value="Entrar">

        <p>¿No tienes cuenta?</p>
        <a href="./pages/register.php">Crear una Cuenta</a>
        <a href="/pages/menu.php">Entrar como Invitado</a>

    </form>

</body>

</html>