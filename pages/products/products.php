<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda de Cupcakes</title>
    <link rel="stylesheet" href="../../scss/products/products.css">
    <script src="https://kit.fontawesome.com/75a5f6846b.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
                    <a style="color: black;" href="carrito.php"><i class="fa-solid fa-cart-shopping icon-cart"></i></a>
                    <div class="count-products">
                        <span id="contador-productos"><?php echo count($_SESSION['carrito'] ?? []); ?></span>
                    </div>
                </div>



                <div class="container-login-icon">
                    <i class="fa-solid fa-user"></i>
                    <?php
                    // Verificar si el usuario está autenticado para mostrar el nombre o el enlace de inicio de sesión
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

        $queryProd = "SELECT * FROM producto";
        $resultProd = $conn->query($queryProd);


        if ($resultProd->num_rows > 0) {
            while ($row = $resultProd->fetch_assoc()) {
                echo '<div class="card">';
                // Mostrar la imagen del producto (asumiendo que se almacena como base64 en la base de datos)
                echo '<img src="data:image/png;base64,' . base64_encode($row['foto']) . '" alt="Imagen del producto">';
                echo '<div class="info">';
                // Mostrar nombre y descripción del producto
                echo '<h3>' . htmlspecialchars($row['Nombre']) . '</h3>';
                echo '<p>' . htmlspecialchars($row['Descripción']) . '</p>';
                echo '</div>';
                // Mostrar el precio del producto
                echo '<div class="price">S/. ' . number_format($row['Precio'], 2) . '</div>';
                // Botón para agregar al carrito, con el ID del producto como atributo data-id
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
                var quantity = 1; // Cantidad predeterminada (puedes ajustarlo según la interfaz del usuario)

                // Aquí podrías obtener la cantidad desde algún control de la interfaz
                // Por ejemplo, si tienes un input de cantidad, podrías hacer algo como:
                // var quantity = parseInt($(this).closest(".producto").find(".cantidad-input").val());

                $.ajax({
                    url: '../../php/products/agregar_producto.php',
                    type: 'POST',
                    data: {
                        id: productId,
                        quantity: quantity // Enviar la cantidad al backend
                    },
                    success: function(response) {
                        var data = JSON.parse(response);
                        if (data.status == 'success') {
                            var carritoCount = parseInt($("#contador-productos").text());
                            $("#contador-productos").text(carritoCount + 1);
                            // Actualizar cualquier otra parte de la interfaz que necesite refrescarse
                            actualizarCarrito(); // Por ejemplo, una función para actualizar la lista de productos en el carrito
                        } else {
                            alert(data.message);
                        }
                    }
                });
            });
        });


        const container = document.querySelector(".container-selected");
        const links = document.querySelectorAll(".link");

        container.addEventListener("click", (event) => {
            const target = event.target.closest(".link");

            if (target) {
                event.preventDefault();
                links.forEach((link) => link.classList.remove("select"));
                target.classList.add("select");

                const categoriaSeleccionada = target.getAttribute("data-categoria");

                obtenerProductos(categoriaSeleccionada);
            }
        });

        function obtenerProductos(categoria) {
            const rowProductos = document.querySelector(".productos-container");

            rowProductos.innerHTML = '<p>Cargando productos...</p>';

            const xhr = new XMLHttpRequest();
            xhr.open("GET", `../../php/products/obtener_productos.php?categoria=${encodeURIComponent(categoria)}`, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    rowProductos.innerHTML = xhr.responseText;
                }
            };
            xhr.send();
        }
    </script>

</body>

</html>