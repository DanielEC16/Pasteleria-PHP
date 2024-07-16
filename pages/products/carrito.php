<?php
session_start();
require '../../php/conexion.php';

$total = 0;
$productosCarrito = [];

if (isset($_SESSION['carrito']) && !empty($_SESSION['carrito'])) {
    $ids = array_column($_SESSION['carrito'], 'id');
    $ids = implode(',', $ids);

    $queryProd = "SELECT * FROM producto WHERE ID IN ($ids)";
    $resultProd = $conn->query($queryProd);

    while ($row = $resultProd->fetch_assoc()) {
        foreach ($_SESSION['carrito'] as $producto) {
            // Verifica si 'id' está definido en $producto antes de usarlo
            if (isset($producto['id']) && $producto['id'] == $row['ID']) {
                $row['cantidad'] = 1;
                $productosCarrito[] = $row;
                $total += $row['Precio'] * $row['cantidad'];
            }
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Carrito de Compras</title>
    <link rel="stylesheet" href="carrito.css">
</head>

<body>
    <h1>Carrito de Compras</h1>
    <div class="productos-carrito">
        <?php if (count($productosCarrito) > 0) : ?>
            <?php foreach ($productosCarrito as $producto) : ?>
                <div class="producto-carrito">
                    <img src="data:image/png;base64,<?php echo base64_encode($producto['foto']); ?>" alt="Imagen del producto">
                    <h2><?php echo htmlspecialchars($producto['Nombre']); ?></h2>
                    <p><?php echo htmlspecialchars($producto['Descripción']); ?></p>
                    <p>Precio: S/. <span class="precio"><?php echo number_format($producto['Precio'], 2); ?></span></p>
                    <div class="cantidad-carrito">
                        <button class="btn-menos" data-id="<?php echo $producto['ID']; ?>">-</button>
                        <span class="cantidad"><?php echo $producto['cantidad']; ?></span>
                        <button class="btn-mas" data-id="<?php echo $producto['ID']; ?>">+</button>
                    </div>
                    <p>Subtotal: S/. <span class="subtotal"><?php echo number_format($producto['Precio'] * $producto['cantidad'], 2); ?></span></p>
                    <form action="../../php/products/quitar_producto.php" method="post">
                        <input type="hidden" name="id" value="<?php echo $producto['ID']; ?>">
                        <button type="submit">Quitar del Carrito</button>
                    </form>
                </div>
            <?php endforeach; ?>
            <h3>Total a pagar: S/. <span id="total"><?php echo number_format($total, 2); ?></span></h3>
            <button id="realizar-pedido">Realizar Pedido</button>
        <?php else : ?>
            <p>El carrito está vacío.</p>
        <?php endif; ?>
    </div>
    <script src="carrito.js"></script>
</body>

<style>
    /* Estilos generales */
body {
    font-family: Arial, sans-serif;
    background-color: #f2f2f2;
    margin: 0;
    padding: 0;
}

h1 {
    text-align: center;
    margin-top: 20px;
    color: #333;
}

.productos-carrito {
    max-width: 800px;
    margin: 20px auto;
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.producto-carrito {
    display: flex;
    border-bottom: 1px solid #ddd;
    padding: 10px 0;
}

.producto-carrito img {
    max-width: 100px;
    margin-right: 20px;
    border-radius: 8px;
}

.producto-carrito h2 {
    margin-bottom: 5px;
    font-size: 1.2rem;
    color: #333;
}

.producto-carrito p {
    margin-bottom: 10px;
    color: #666;
}

.producto-carrito .precio {
    font-weight: bold;
}

.cantidad-carrito {
    display: flex;
    align-items: center;
}

.cantidad-carrito button {
    background-color: #007bff;
    color: #fff;
    border: none;
    padding: 5px 10px;
    margin: 0 5px;
    cursor: pointer;
    border-radius: 4px;
}

.cantidad-carrito button:hover {
    background-color: #0056b3;
}

.subtotal {
    font-weight: bold;
}

h3 {
    margin-top: 20px;
    text-align: right;
    font-size: 1.3rem;
}

button[type="submit"] {
    background-color: #28a745;
    color: #fff;
    border: none;
    padding: 10px 20px;
    cursor: pointer;
    border-radius: 4px;
    font-size: 1rem;
}

button[type="submit"]:hover {
    background-color: #218838;
}

p.empty-cart {
    text-align: center;
    margin-top: 20px;
    color: #666;
}

</style>

</html>