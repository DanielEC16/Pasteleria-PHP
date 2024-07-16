<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productoId = intval($_POST['id']);
    $cantidad = 1; // Por defecto, la cantidad es 1

    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = [];
    }

    $exists = false;

    foreach ($_SESSION['carrito'] as &$producto) {
        if ($producto['id'] == $productoId) {
            $producto['cantidad'] += $cantidad;
            $exists = true;
            break;
        }
    }

    if (!$exists) {
        $_SESSION['carrito'][] = ['id' => $productoId, 'cantidad' => $cantidad];
    }

    echo json_encode(['status' => 'success', 'message' => 'Producto agregado al carrito']);
}
?>
