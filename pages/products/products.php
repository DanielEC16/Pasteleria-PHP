<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda de Cupcakes</title>
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
                <li class="link"><a href="../../index.php">Dirección</a></li>
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
                        //*! AQUÍ VAN LOS PRODUCTOS
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
            <a href="#" class="link select" data-categoria="Todo"><img src="../../img/products-icons/icon-4.png" alt=""><span>Todo</span></a>
            <?php
            require '../../php/conexion.php';

            $queryCat = "SELECT * FROM categoria";
            $resultCat = $conn->query($queryCat);

            if ($resultCat->num_rows > 0) {
                while ($row = $resultCat->fetch_assoc()) {
                    $categoria_id = $row['cod'];
                    $nombre_categoria = $row['nombre'];
                    $icono_base64 = base64_encode($row['icono']);
                    echo "<a href='../../php/products/obtener_productos.php?categoria=" . urlencode($nombre_categoria) . "' class='link' data-categoria='$nombre_categoria'>";
                    echo "<img src='data:image/png;base64, $icono_base64' alt='$nombre_categoria'>";
                    echo "<span>$nombre_categoria</span></a>";
                }
            } else {
                echo "<p>No se encontraron categorías.</p>";
            }
            $conn->close();
            ?>
        </div>
    </main>


    <section class="search-container">
        <div class="search-input">
            <input type="text">
            <div class="img"><i class="fa-solid fa-magnifying-glass"></i></div>
        </div>
    </section>

    <section class="productos-container">
        <?php
        require '../../php/conexion.php';

        // Consulta inicial para obtener todos los productos
        $queryProd = "SELECT * FROM producto";
        $resultProd = $conn->query($queryProd);

        if ($resultProd->num_rows > 0) {
            while ($row = $resultProd->fetch_assoc()) {
                echo '<div class="card">';
                echo '<img src="data:image/png;base64,' . base64_encode($row['foto']) . '" alt="Imagen del producto">';
                echo '<div class="info">';
                echo '<h3>' . $row['Nombre'] . '</h3>';
                echo '<p>' . $row['Descripción'] . '</p>';
                echo '</div>';
                echo '<div class="price">S/. ' . number_format($row['Precio'], 2) . '</div>';
                echo '<button class="btn-add-cart" data-id="' . $row['ID'] . '">Agregar al carrito <i class="fa-solid fa-circle-plus"></i></button>';
                echo '</div>';
            }
        } else {
            echo "<p>No se encontraron productos.</p>";
        }
        $conn->close();
        ?>
    </section>

    <script src="../../JS/carrito/carrito.js"></script>
    
    <script>
        $(document).ready(function() {
            $(".btn-add-cart").click(function() {
                var productId = $(this).data("id");
                $.ajax({
                    url: 'agregar.php',
                    type: 'POST',
                    data: { id: productId },
                    success: function(response) {
                        var carritoCount = parseInt($("#carrito-count").text());
                        $("#carrito-count").text(carritoCount + 1);
                    }
                });
            });
        });
    </script>


</body>

</html>

