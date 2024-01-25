<?php

    if(!isset($_GET["user"])){

    }

?>
    

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <title>| Menu</title>
</head>

<body class="menu">
    <header>
        <div>
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-meat" width="34" height="34"
                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M13.62 8.382l1.966 -1.967a2 2 0 1 1 3.414 -1.415a2 2 0 1 1 -1.413 3.414l-1.82 1.821" />
                <path
                    d="M5.904 18.596c2.733 2.734 5.9 4 7.07 2.829c1.172 -1.172 -.094 -4.338 -2.828 -7.071c-2.733 -2.734 -5.9 -4 -7.07 -2.829c-1.172 1.172 .094 4.338 2.828 7.071z" />
                <path d="M7.5 16l1 1" />
                <path
                    d="M12.975 21.425c3.905 -3.906 4.855 -9.288 2.121 -12.021c-2.733 -2.734 -8.115 -1.784 -12.02 2.121" />
            </svg>
            <h1>Tienda Kebab</h1>
        </div>
        <nav>
            <ul>
                <li><a href="" id="active">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-tools-kitchen-2"
                            width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path
                                d="M19 3v12h-5c-.023 -3.681 .184 -7.406 5 -12zm0 12v6h-1v-3m-10 -14v17m-3 -17v3a3 3 0 1 0 6 0v-3" />
                        </svg>
                        Menu
                    </a></li>
                    <!-- Aquí vamos a hacer el php para en caso de que entren como invitado se muestre un header u otro. -->
                <li><a href="">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user" width="24"
                            height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                            <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                        </svg>
                        Mi Perfil
                    </a></li>
                <li><a href="" id="basket">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-shopping-cart"
                            width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M6 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                            <path d="M17 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                            <path d="M17 17h-11v-14h-2" />
                            <path d="M6 5l14 1l-1 7h-13" />
                        </svg>
                        Carrito<span id="notify">3</span>
                    </a></li>
            </ul>
        </nav>
    </header>
    <main>
        <h1>Productos</h1>
        <hr>
        <h2>Menus</h2>
        <section>
            <div>
                <img src="https://www.kebabalguazas.es/wp-content/uploads/2021/06/menus_portada.png" alt="">
                <h3>Menu Kebab Gourmet</h3>
                <p>7.55 €</p>
            </div>
            <div>
                <img src="https://pngimg.com/d/kebab_PNG38.png" alt="">
                <h3>Menu Kebab Simple</h3>
                <p>7.00 €</p>
            </div>
            <div>
                <img src="https://www.kebabambar.com/wp-content/uploads/2017/09/Menu-Kebab-Falafel.png" alt="">
                <h3>Menu Vegetal</h3>
                <p>7.95 €</p>
            </div>
            <div>
                <img src="https://www.royalkebab-pizzeria.es/wp-content/uploads/2021/09/menu_7.png" alt="">
                <h3>Menu Burger</h3>
                <p>5.00 €</p>
            </div>
            <div>
                <img src="https://labrasakebab.com/uploads/menu/Kebab-Menu-Pita.png" alt="">
                <h3>Menu Casa</h3>
                <p>8.00 €</p>
            </div>
        </section>
    </main>
</body>

</html>