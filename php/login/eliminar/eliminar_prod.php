<?php
require '../../conexion.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $idProducto = $_GET['id'];

    $query = "DELETE FROM producto WHERE ID = $idProducto";

    if (mysqli_query($conn, $query)) {
        $mensaje = 'Producto eliminado correctamente.';
        $url = "../../../pages/login/admin.php"; // Redirige a la página de administrador o a donde sea necesario
        header("Location: $url?mensaje=" . urlencode($mensaje));
        exit;
    } else {
        echo "<p>Error al eliminar el producto: " . mysqli_error($conn) . "</p>";
    }
} else {
    echo "<p>ID de producto no válido.</p>";
}

$conn->close();
?>
