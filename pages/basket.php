<?php

ob_start(); 
session_start();
if(!isset($_GET["user"])){
    header("Location: ../index.php");
}


function mostrar()
{
    
    $cadena_conexion = "mysql:dbname=proyecto_ki;host=localhost";
    $root = "root";
    $key = "";

    $db = new PDO($cadena_conexion, $root, $key);
    $data = $db->query("SELECT producto.*, carrito.id_carrito
                        FROM carrito
                        INNER JOIN pedido ON carrito.pedido = pedido.id_pedido
                        INNER JOIN producto ON carrito.producto = producto.id_producto
                        WHERE pedido.usuario = " . $_GET['user'] ."");

    foreach ($data as $produc) {
        $idCarro = $produc["id_carrito"];
        $idproCarrito = $produc["id_producto"];
        $precioCarrito = $produc["precio"];
        $nombreCarrito = $produc["nombre"];
        $imgCarrito = $produc["img"];

        echo '
    <div id="card">
        <img src=" ' . $imgCarrito . ' " alt="">
        <h3>' . $nombreCarrito . '</h3>
        <div>
            <p> ' .  $precioCarrito . ' €</p>
        </div>
        <form method="post" action="' . $_SERVER["PHP_SELF"] . '?' . $_SERVER["QUERY_STRING"] .'">
            <input type="submit" value="Eliminar" name="' . $idCarro . '">
        </form>
    </div>
    ';

        if(isset($_POST["$idCarro"])){
            $db->query("DELETE FROM carrito WHERE id_carrito = '$idCarro'");
        }

    }
    
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <title>| Carrito</title>
</head>

<body id="body_basket">
    <!-- Header (Copia y Pega)-->
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
                <?php if (isset($_GET["user"])) {
                    echo '
                <li>
                <a href="./menu.php?user=' . $_GET["user"] . '">
                    <svg width="24"
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
                <a href="#" id="basket">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-shopping-cart" width="24"
                        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M6 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                        <path d="M17 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                        <path d="M17 17h-11v-14h-2" />
                        <path d="M6 5l14 1l-1 7h-13" />
                    </svg>
                        Carrito<span id="notify"> ' . $_SESSION["count"] . '</span>
                </a>
            </li>
    ';
                } ?>
            </ul>
        </nav>

    </header>
    <main>
        <!-- Carrito. Hay que crear un div que contenga todos los objetos del Carrito y detectar cuantos hay de cada uno de ellos. -->
        <section>
            <h3>Tu Carrito</h3>
            <hr>
            <ul class="list">
                <!-- Aqui se genera la información dinamicamente -->
                <?php mostrar() ?>
            </ul>
        </section>
        <section class="button">

            <?php 
                if (isset($_POST["finish"])) {
                    $cadena_conexion = "mysql:dbname=proyecto_ki;host=localhost";
                    $root = "root";
                    $key = "";
                
                    $db = new PDO($cadena_conexion, $root, $key);

                    setcookie("C_pedido", 1, time() - 3600);

                    $db->query("DELETE carrito.* FROM carrito, pedido WHERE usuario = ". $_GET["user"] ."");
                    header("location:./menu.php?user=" . $_GET["user"]);

                }

                if($_SESSION["count"] == 0){
                    echo '<p>Aún no has añadido ningún producto.</p>';
                }
            ?>
                
            <form method="post">
                <input type="submit" value="Finalizar Compra!" name="finish">
            </form>
        </section>
    </main>

</body>

</html>