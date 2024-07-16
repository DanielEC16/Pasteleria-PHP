<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $productoId = intval($_POST['id']);

    if (isset($_SESSION['carrito'])) {
        foreach ($_SESSION['carrito'] as $key => $producto) {
            if ($producto['id'] == $productoId) {
                // Reducir la cantidad o eliminar el producto según sea necesario
                if ($producto['cantidad'] > 1) {
                    $_SESSION['carrito'][$key]['cantidad']--; // Reducir la cantidad si es más de 1
                } else {
                    unset($_SESSION['carrito'][$key]); // Eliminar el producto si la cantidad es 1
                }
                break;
            }
        }
        $_SESSION['carrito'] = array_values($_SESSION['carrito']); // Reindexar el arreglo
    }

    // Puedes redirigir de vuelta al carrito o responder con un mensaje JSON, dependiendo de tu flujo de aplicación
    header('Location: ../../pages/products/carrito.php');
    exit();
}
?>
