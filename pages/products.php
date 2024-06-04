<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../scss/products/style.css">
</head>

<body>

    <header>
        <nav class="nav__container">
            <div class="nav-logo">
                <img src="../img/logo/logo-coffee.png" alt="" class="logo">
                <span>Cupcake's</span>
            </div>
            <ul class="nav-links">
                <li class="link"><a href="../index.html">Inicio</a></li>
                <li class="link"><a href="#">Productos</a></li>
                <li class="link"><a href="../index.html">Direccion</a></li>
                <li class="link"><a href="../index.html">Contacto</a></li>
            </ul>
            <button id="modalBtn" class="btn">Contactanos!</button>
        </nav>
    </header>
    <br>
    <main class="selected">
        <div class="container-selected">
            <a class="select" href="#"><img src="../img/products-icons/icon-5.png" alt=""><span>Todo</span></a>
            <a href="products/bocaditos.html"><img src="../img/products-icons/icon-1.png" alt=""><span>Bocaditos</span></a>
            <a href="products/tortas.html"><img src="../img/products-icons/icon-2.png" alt=""><span>Tortas</span></a>
            <a href="products/porciones.html"><img src="../img/products-icons/icon-3.png" alt=""><span>Porciones</span></a>
            <a href="products/pays.html"><img src="../img/products-icons/icon-4.png" alt=""><span>Pays</span></a>




            <!-- CARITTO DE COMPRAS -->

            <div class="container-icon">
                <div class="container-cart-icon">
                    <i class="fa-solid fa-cart-shopping icon-cart"></i>
                    <div class="count-products">
                        <span id="contador-productos">0</span>
                    </div>
                </div>

                <div class="container-cart-products hidden-cart">
                    <div class="row-product hidden">
                        <div class="cart-product">
                            <div class="info-cart-product">
                                <span class="cantidad-producto-carrito">1</span>
                                <p class="titulo-producto-carrito">Zapatos Nike</p>
                                <span class="precio-producto-carrito">$80</span>
                            </div>
                            <i class="fa-solid fa-xmark icon-close"></i>
                        </div>
                    </div>

                    <div class="cart-total hidden">
                        <h3>Total:</h3>
                        <span class="total-pagar">$200</span>
                    </div>
                    <p class="cart-empty">El carrito está vacío</p>
                </div>
            </div>
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
            <img src="../img/Productos/0.jpg" alt="">
            <div class="info">
                <h3>Bolas de Helado</h3>
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Consectetur nemo ab saepe. Earum, sapiente.
                Eaque, reiciendis.
            </div>
            <div class="price">S/. 99.90</div>
            <button class="btn-add-cart">Agregar al carrito <i class="fa-solid fa-circle-plus"></i> </button>
        </div>
        <div class="card">
            <img src="../img/Productos/1.jpg" alt="">
            <div class="info">
                <h3>Indulgencia</h3>
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Consectetur nemo ab saepe. Earum, sapiente.
                Eaque, reiciendis.
            </div>
            <div class="price">S/. 99.90</div>
            <button class="btn-add-cart">Agregar al carrito <i class="fa-solid fa-circle-plus"></i> </button>
        </div>
        <div class="card">
            <img src="../img/Productos/2.jpg" alt="">
            <div class="info">
                <h3>Tarta de chocolate</h3>
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Consectetur nemo ab saepe. Earum, sapiente.
                Eaque, reiciendis.
            </div>
            <div class="price">S/. 99.90</div>
            <button class="btn-add-cart">Agregar al carrito <i class="fa-solid fa-circle-plus"></i> </button>
        </div>
        <div class="card">
            <img src="../img/Productos/3.jpg" alt="">
            <div class="info">
                <h3>Trufas</h3>
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Consectetur nemo ab saepe. Earum, sapiente.
                Eaque, reiciendis.
            </div>
            <div class="price">S/. 99.90</div>
            <button class="btn-add-cart">Agregar al carrito <i class="fa-solid fa-circle-plus"></i> </button>
        </div>
        <div class="card">
            <img src="../img/Productos/4.jpg" alt="">
            <div class="info">
                <h3>Pastel de Chocolate</h3>
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Consectetur nemo ab saepe. Earum, sapiente.
                Eaque, reiciendis.
            </div>
            <div class="price">S/. 99.90</div>
            <button class="btn-add-cart">Agregar al carrito <i class="fa-solid fa-circle-plus"></i> </button>
        </div>
        <?php
        require '../admin/php/conexion.php';
        $sql = "SELECT Nombre, Descripción, precio, foto FROM producto";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Salida de datos de cada fila
            while ($row = $result->fetch_assoc()) {
                // Convertir el blob a una URL
                $foto_url = 'data:image/jpg;base64,' . base64_encode($row['foto']);
        ?>
                <div class="card">
                    <img src="<?php echo $foto_url; ?>">
                    <div class="info">
                        <h3><?php echo $row["Nombre"]; ?></h3>
                        <p><?php echo $row["Descripción"]; ?></p>
                    </div>
                    <div class="price">S/. <?php echo $row["precio"]; ?></div>
                    <button class="btn-add-cart">Agregar al carrito <i class="fa-solid fa-circle-plus"></i> </button>
                </div>
        <?php
            }
        } else {
            echo "0 resultados";
        }

        // Cerrar conexión
        $conn->close();
        ?>


    </section>

    <script src="./../admin/JS/carrito/carrito.js"></script>

    <script src="https://kit.fontawesome.com/75a5f6846b.js" crossorigin="anonymous"></script>

</body>

</html>