<?php
ob_start();
session_start();
function contarCarro(){
    $cadena_conexion = "mysql:dbname=proyecto_ki;host=localhost";
    $root = "root";
    $key = "";

    $db = new PDO($cadena_conexion, $root, $key);

    // $carrito = $db->query("SELECT * FROM  carrito, pedido WHERE usuario = " . $_GET['user'] . "");

    $prueba = $db->query("SELECT * FROM carrito");
    $_SESSION["count"] = $prueba->rowCount();

}

function botonFiltrar()
{
    $cadena_conexion = "mysql:dbname=proyecto_ki;host=localhost";
    $root = "root";
    $key = "";

    $db = new PDO($cadena_conexion, $root, $key);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if (isset($_POST["filtrar"])) {
        setcookie("C_pedido" ,"1", time() +  3600);

        error_reporting(0);
        if ($_POST["categoria"] == null){
            $data = $db->query("SELECT * FROM producto");
        }else{
            $categoria = $_POST["categoria"];
            $data = $db->query("SELECT * FROM producto WHERE categoria = $categoria");
        }

        foreach ($data as $produc) {
            $_SESSION["id"] = $produc["id_producto"];
            $_SESSION["precio"] = $produc["precio"];
            $_SESSION["nombre"] = $produc["nombre"];
            $_SESSION["categoria"] = $produc["categoria"];
            $_SESSION["img"] = $produc["img"];
            mostrar();
        }
        
    } else {
        $data = $db->query("SELECT * FROM producto");
    
        foreach ($data as $produc) {
            $_SESSION["id"] = $produc["id_producto"];
            $_SESSION["precio"] = $produc["precio"];
            $_SESSION["nombre"] = $produc["nombre"];
            $_SESSION["categoria"] = $produc["categoria"];
            $_SESSION["img"] = $produc["img"];
            mostrar();
        }
    }

}


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
        <img src=" ' . $_SESSION["img"] . ' " alt="">
        <h3>' . $_SESSION["nombre"] . $categoria . '</h3>
        <div>
            <p> ' . $_SESSION["precio"] . ' €</p>
            <form method="POST" id="addcart">' . $addCart  .
        '</form>
        </div>
    </div>
    ';
    
    if (isset($_POST[$_SESSION["id"]])) {
        // Llama a la función para agregar el producto al carrito
        addCarrito($_SESSION["id"]);
    }
    contarCarro();
}



function addCarrito($id){
    $cadena_conexion = "mysql:dbname=proyecto_ki;host=localhost";
    $root = "root";
    $key = "";

    $id_usuario = $_SESSION["usuario"];

    try {
        $db = new PDO($cadena_conexion, $root, $key);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Inicia la transacción
        $db->beginTransaction();


        //set cookie
        if (!isset($_COOKIE["C_pedido"])) {
                // Establecer la cookie cuando se envía el formulario de filtrar
                setcookie("C_pedido", 1, time() + 3600);

                // Insertar un nuevo pedido
                $crearPedido = $db->prepare("INSERT INTO pedido(entrega, usuario) VALUES (1, $id_usuario)");
                $crearPedido->execute();
                // Obtener el ID del pedido recién creado
                $idPedidoFetch = $db->lastInsertId();
                // print_r($idPedidoFetch);

                $_SESSION["IDpf"] = $idPedidoFetch;

        }

                // Insertar en la tabla carrito
                $carritoAdd = $db->prepare("INSERT INTO carrito(pedido, producto) VALUES (". $_SESSION['IDpf'] .", $id)");
                $carritoAdd->execute();

                // Commit si todas las consultas se ejecutaron correctamente
                $db->commit();
    } catch (PDOException $e) {
        // Rollback en caso de error
        $db->rollBack();

        // Manejo de errores, podrías imprimir el mensaje de error o loguearlo
        echo "Error: " . $e->getMessage();
        return false; // o algún otro indicador de error si es necesario
    }

}




?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon">
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
                <?php 
                if (!isset($_GET["user"])) {
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
                            Carrito<span id="notify">'. $_SESSION["count"] .'</span>
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

        <!-- action=<?php htmlspecialchars($_SERVER['PHP_SELF']) ?> -->

        <form  method="post" id="filter">
            <label>
                <input type="radio" name="categoria" value="1">
                Pollo
            </label>
            <label>
                <input type="radio" name="categoria" value="2">
                Ternera
            </label>
            <label>
                <input type="radio" name="categoria" value="3">
                Mixto
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
