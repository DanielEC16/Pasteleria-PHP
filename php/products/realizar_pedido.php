<?php
session_start();
require '../conexion.php';

// Simulación del usuarioID (cámbialo según tu lógica real de obtención de usuario)
$usuarioID = 1; // Este es un ejemplo ficticio, deberías obtenerlo de la sesión del usuario

if (isset($_SESSION['carrito']) && !empty($_SESSION['carrito']) && $usuarioID) {
    $productosCarrito = $_SESSION['carrito'];
    $totalVenta = calcularTotalVenta($productosCarrito); // Función para calcular el total de la venta

    // Insertar la venta en la tabla 'venta'
    $queryInsertVenta = "INSERT INTO venta (fecha, total, usuarioID) VALUES (NOW(), ?, ?)";
    $stmtVenta = $conn->prepare($queryInsertVenta);
    $stmtVenta->bind_param("di", $totalVenta, $usuarioID);

    if ($stmtVenta->execute()) {
        $ventaID = $stmtVenta->insert_id;

        // Insertar detalles de la venta en la tabla 'detalles_venta'
        $queryInsertDetalle = "INSERT INTO detalles_venta (venta_ID, producto_ID, cantidad) VALUES (?, ?, ?)";
        $stmtDetalle = $conn->prepare($queryInsertDetalle);

        foreach ($productosCarrito as $producto) {
            $descripcionProducto = $producto['Descripción']; // Obtener la descripción del producto

            // Consulta para obtener el ID del producto basado en la descripción
            $queryProducto = "SELECT ID FROM producto WHERE Descripción = ?";
            $stmtProducto = $conn->prepare($queryProducto);
            $stmtProducto->bind_param("s", $descripcionProducto);
            $stmtProducto->execute();
            $stmtProducto->bind_result($productoID);
            $stmtProducto->fetch();
            $stmtProducto->close();

            // Verificar que se obtuvo el ID del producto
            if ($productoID) {
                $cantidad = $producto['cantidad']; // Obtener la cantidad del producto
                $stmtDetalle->bind_param("iii", $ventaID, $productoID, $cantidad);
                $stmtDetalle->execute();
            } else {
                echo "Error: No se encontró el ID del producto para la descripción '$descripcionProducto'.";
                exit();
            }
        }

        // Limpiar el carrito después de realizar la venta
        unset($_SESSION['carrito']);

        // Redirigir a una página de confirmación o mostrar un mensaje de éxito
        header("Location: ../../carrito_confirmacion.php");
        exit();
    } else {
        echo "Error al insertar la venta en la tabla 'venta'.";
        exit();
    }

    $stmtVenta->close();
    $stmtDetalle->close();
    $conn->close();
} else {
    echo "No se encontraron productos en el carrito para realizar la venta o no se ha iniciado sesión correctamente.";
    exit();
}

function calcularTotalVenta($productosCarrito) {
    $total = 0;
    foreach ($productosCarrito as $producto) {
        $total += $producto['Precio'] * $producto['cantidad'];
    }
    return $total;
}
?>
