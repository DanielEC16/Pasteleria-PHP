<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="shortcut icon" href="./img/logo/logo-coffee.png" type="image/x-icon">
    <link rel="stylesheet" href="./scss//index/style.css">
    <!-- CSS Swipper -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
</head>

<body>
    <header>
        <nav class="nav__container">
            <div class="nav-logo">
                <img src="img/logo/logo-coffee.png" alt="" class="logo">
                <span>Cupcake's</span>
            </div>
            <ul class="nav-links">
                <li class="link"><a href="">Inicio</a></li>
                <li class="link"><a href="pages/products/products.php">Productos</a></li>
                <li class="link"><a href="">Direccion</a></li>
                <li class="link"><a href="">Contacto</a></li>
            </ul>
            <button id="modalBtn" class="btn">Contactanos!</button>
        </nav>

        <!-- Carrousel Swipper -->
        <main class="carrousel_swipper">
            <div class="carrousel_text">
                <span>Pasteleria</span>
                <h1>D'Leonisa</h1>
                <p>100% Peruano</p>
                <a href="./pages/products.html">Ver Poductos</a>
            </div>
            <div class="swiper_1">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <img src="img/banner/banner1.jpg" alt="">
                    </div>
                    <div class="swiper-slide">
                        <img src="img/banner/banner2.jpg" alt="">
                    </div>
                    <div class="swiper-slide">
                        <img src="img/banner/banner3.jpg" alt="">
                    </div>
                    <div class="swiper-slide">
                        <img src="img/banner/banner4.jpg" alt="">
                    </div>
                    <div class="swiper-slide">
                        <img src="img/banner/banner5.jpg" alt="">
                    </div>
                </div>
                <div class="swiper-pagination"></div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
        </main>
    </header>

    <section class="locales">
        <h3>!Visita nuestros locales¡</h3>
        <div class="swiper_2">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <img src="img/locale1.webp" alt="">
                </div>
                <div class="swiper-slide">
                    <img src="img/locale2.jpg" alt="">
                </div>
                <div class="swiper-slide">
                    <img src="img/locale3.jpg" alt="">
                </div>
                <div class="swiper-slide">
                    <img src="img/locale4.jpg" alt="">
                </div>
            </div>
        </div>
    </section>





    <!-- Library Swipper -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="./JS/swipper.js"></script>

</body>

</html>