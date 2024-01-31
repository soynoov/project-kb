<?php

session_start();

function mostrar()
{
    if ($_SESSION["categoria"] == 1) {
        $categoria = " - pollo";
    } else if ($_SESSION["categoria"] == 2) {
        $categoria = " - ternera";
    } else if ($_SESSION["categoria"] == 3) {
        $categoria = " - mixto";
    } else if ($_SESSION["categoria"] == 4) {
        $categoria = " - vegetariano";
    } else {
        $categoria = null;
    }

    if (isset($_GET["user"])) {
        $addCart = '<input type="submit" name="' . $_SESSION["id"] . '" value="Add Cart">';
    } else {
        $addCart = null;
    };

    echo '
    <div id="card">
        <img src="https://www.kebabalguazas.es/wp-content/uploads/2021/06/menus_portada.png" alt="">
        <h3>' . $_SESSION["nombre"] . $categoria . '</h3>
        <div>
            <p> ' . $_SESSION["precio"] . ' €</p>
            <form method="POST" id="addcart">' . $addCart  .
        '</form>
        </div>
    </div>
    ';


if (isset($_POST[$_SESSION["id"]])) {
    // Ahora seria almacenar el id en un valor y si se puede llamamos la funcion addCarrito([$_SESSION["id"]]) con el valor ya predefinido como en js;
    echo  $_SESSION["id"] ;
}

}

function addCarrito(){
                  
    $cadena_conexion = "mysql:dbname=proyecto_ki;host=localhost";
    $root = "root";
    $key = "";

    $db = new PDO($cadena_conexion, $root, $key);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    echo "puto";

}

function botonFiltrar()
{
    $cadena_conexion = "mysql:dbname=proyecto_ki;host=localhost";
    $root = "root";
    $key = "";

    $db = new PDO($cadena_conexion, $root, $key);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if (isset($_POST["filtrar"])) {

        $categoria = $_POST["categoria"];
        $data = $db->query("SELECT * FROM producto WHERE categoria = $categoria");

        foreach ($data as $produc) {
            $_SESSION["id"] = $produc["id_producto"];
            $_SESSION["precio"] = $produc["precio"];
            $_SESSION["nombre"] = $produc["nombre"];
            $_SESSION["categoria"] = $produc["categoria"];
            mostrar();
        }
    } else {
        $data = $db->query("SELECT * FROM producto");


        foreach ($data as $produc) {
            $_SESSION["id"] = $produc["id_producto"];
            $_SESSION["precio"] = $produc["precio"];
            $_SESSION["nombre"] = $produc["nombre"];
            $_SESSION["categoria"] = $produc["categoria"];
            mostrar();
        }
    }
}


?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
    <title>| Menu</title>
</head>

<body class="menu">
    <!-- Header -->
    <header>
        <!-- Logo de la Empresa con su Titulo -->
        <div>
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-meat" width="34" height="34" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M13.62 8.382l1.966 -1.967a2 2 0 1 1 3.414 -1.415a2 2 0 1 1 -1.413 3.414l-1.82 1.821" />
                <path d="M5.904 18.596c2.733 2.734 5.9 4 7.07 2.829c1.172 -1.172 -.094 -4.338 -2.828 -7.071c-2.733 -2.734 -5.9 -4 -7.07 -2.829c-1.172 1.172 .094 4.338 2.828 7.071z" />
                <path d="M7.5 16l1 1" />
                <path d="M12.975 21.425c3.905 -3.906 4.855 -9.288 2.121 -12.021c-2.733 -2.734 -8.115 -1.784 -12.02 2.121" />
            </svg>
            <h1>Tienda Kebab</h1>
        </div>
        <!-- Barra de Navegación con las respectivas opciones disponibles -->
        <nav>
            <ul>
                <!-- Opción de Navegación del Menu -->
                <?php if (!isset($_GET["user"])) {
                    echo '
                <li>
                    <a href="../index.php" id="basket">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-login-2" width="24" height="24"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M9 8v-2a2 2 0 0 1 2 -2h7a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-7a2 2 0 0 1 -2 -2v-2" />
                            <path d="M3 12h13l-3 -3" />
                            <path d="M13 15l3 -3" />
                        </svg>
                        Iniciar Sesión
                    </a>
                </li>
        ';
                } else {
                    echo '
                <li>
                    <a href="" id="active">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-tools-kitchen-2" width="24"
                            height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M19 3v12h-5c-.023 -3.681 .184 -7.406 5 -12zm0 12v6h-1v-3m-10 -14v17m-3 -17v3a3 3 0 1 0 6 0v-3" />
                        </svg>
                            Menu
                    </a>
                </li>
                <!-- Aquí vamos a hacer el php para en caso de que entren como invitado se muestre un header u otro. -->
                <li>
                    <a href="">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user" width="24" height="24"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                            <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                        </svg>
                            Mi Perfil
                    </a>
                </li>
                <li>
                    <a href="./basket.php?user=' . $_GET["user"] . '" id="basket">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-shopping-cart" width="24"
                            height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M6 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                            <path d="M17 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                            <path d="M17 17h-11v-14h-2" />
                            <path d="M6 5l14 1l-1 7h-13" />
                        </svg>
                            Carrito<span id="notify">3</span>
                    </a>
                </li>
    ';
                } 

                ?>
            </ul>
        </nav>

    </header>
    <!-- Main -->
    <main>

        <h1>Productos</h1>
        <hr>
        <!-- Secciones de la Carta (El Menu) -->
        <h2>Categorias</h2>
        <form method="post" id="filter">
            <label>
                <input type="radio" name="categoria" value="2">
                Ternera
            </label>
            <label>
                <input type="radio" name="categoria" value="1">
                Pollo
            </label>
            <label>
                <input type="radio" name="categoria" value="5">
                Complementos
            </label>
            <label>
                <input type="radio" name="categoria" value="6">
                Bebidas
            </label>
            <input type="submit" value="Filtrar" name="filtrar">
        </form>
        <section id="menu">
            <?php botonFiltrar(); ?>
        </section>
    </main>

</body>

</html>