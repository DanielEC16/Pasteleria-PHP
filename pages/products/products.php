<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../scss/products/products.css">
    <script src="https://kit.fontawesome.com/75a5f6846b.js" crossorigin="anonymous"></script>
</head>

<body>

    <header>
        <nav class="nav__container">
            <div class="nav-logo">
                <img src="../../img/logo/logo-coffee.png" alt="" class="logo">
                <span>Cupcake's</span>
            </div>
            <ul class="nav-links">
                <li class="link"><a href="../../index.php">Inicio</a></li>
                <li class="link"><a href="#">Productos</a></li>
                <li class="link"><a href="../../index.php">Direccion</a></li>
                <li class="link"><a href="../../index.php">Contacto</a></li>
            </ul>
            <div class="container-icon">
                <div class="container-cart-icon">
                    <i class="fa-solid fa-cart-shopping icon-cart"></i>
                    <div class="count-products">
                        <span id="contador-productos">0</span>
                    </div>
                </div>

                <div class="container-cart-products hidden-cart">
                    <div class="row-product hidden">
                        //*! AQUI VAN LOS PRODUCTOS
                    </div>

                    <div class="cart-total hidden">
                        <h3>Total:</h3>
                        <span class="total-pagar"></span>
                    </div>
                    <p class="cart-empty">El carrito está vacío</p>
                </div>

                <div class="container-login-icon">
                    <i class="fa-solid fa-user"></i>
                    <?php
                    // Verificar si el usuario está autenticado para mostrar el nombre o el enlace de inicio de sesión
                    session_start();
                    if (isset($_SESSION['usuario'])) {
                        echo '<p>Bienvenido, <br/>' . $_SESSION['nombre'] . '</p>';
                        echo '<a href="../../php/products/logout.php">Cerrar <br/> Sesión</a>';
                    } else {
                        echo '<p><a href="login.php">Iniciar <br/> Sesión</a></p>';
                    }
                    ?>
                </div>

            </div>
        </nav>
    </header>

    <br>
    <main class="selected">
        <div class="container-selected">
            <a href="#" class="link"><img src="../../img/products-icons/icon-5.png" alt=""><span>Todo</span></a>
            <a href="#" class="link"><img src="../../img/products-icons/icon-1.png" alt=""><span>Bocaditos</span></a>
            <a href="#" class="link"><img src="../../img/products-icons/icon-2.png" alt=""><span>Tortas</span></a>
            <a href="#" class="link"><img src="../../img/products-icons/icon-3.png" alt=""><span>Porciones</span></a>
            <a href="#" class="link"><img src="../../img/products-icons/icon-4.png" alt=""><span>Pays</span></a>
        </div>
    </main>


    <section class="search-container">
        <div class="search-input">
            <input type="text">
            <div class="img"><i class="fa-solid fa-magnifying-glass"></i></div>
        </div>
    </section>



    <section class="productos-container">
        <div class="card">
            <img src="../../img/Productos/0.jpg" alt="">
            <div class="info">
                <h3>Bolas de Helado</h3>
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Consectetur nemo ab saepe. Earum, sapiente.
                Eaque, reiciendis.
            </div>
            <div class="price">S/. 99.90</div>
            <button class="btn-add-cart">Agregar al carrito <i class="fa-solid fa-circle-plus"></i> </button>
        </div>
        <div class="card">
            <img src="../../img/Productos/1.jpg" alt="">
            <div class="info">
                <h3>Indulgencia</h3>
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Consectetur nemo ab saepe. Earum, sapiente.
                Eaque, reiciendis.
            </div>
            <div class="price">S/. 99.90</div>
            <button class="btn-add-cart">Agregar al carrito <i class="fa-solid fa-circle-plus"></i> </button>
        </div>



    </section>

    <script src="../../JS/carrito/carrito.js"></script>
    <script>
        const container = document.querySelector(".container-selected");
        const links = document.querySelectorAll(".link");

        container.addEventListener("click", (event) => {
            // Verifica si el clic ocurrió en un enlace con la clase 'link'
            const target = event.target.closest(".link");

            if (target) {
                event.preventDefault(); // Previene la acción por defecto de los enlaces

                // Remueve la clase 'select' de todos los enlaces
                links.forEach((link) => link.classList.remove("select"));

                // Agrega la clase 'select' al enlace clicado
                target.classList.add("select");
            }
        });
    </script>


</body>

</html>