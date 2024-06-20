<?php
require '../../conexion.php';

// Verificar si se recibe el ID de la categoría
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $idCategoria = $_GET['id'];

    // Preparar la consulta para eliminar la categoría
    $query = "DELETE FROM categoria WHERE cod = ?";
    
    // Preparar la consulta para evitar inyecciones SQL
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("i", $idCategoria);  // 'i' indica un entero
        
        // Ejecutar la consulta
        if ($stmt->execute()) {
            $mensaje = 'Categoría eliminada correctamente.';
            $url = "../../../pages/login/admin.php"; // Redirigir a la página de administrador o a donde sea necesario
            header("Location: $url?mensaje=" . urlencode($mensaje));
            exit;
        } else {
            echo "<p>Error al eliminar la categoría: " . $stmt->error . "</p>";
        }

        $stmt->close();
    } else {
        echo "<p>Error al preparar la consulta: " . $conn->error . "</p>";
    }
} else {
    echo "<p>ID de categoría no válido.</p>";
}

// Cerrar la conexión a la base de datos
$conn->close();
?>
