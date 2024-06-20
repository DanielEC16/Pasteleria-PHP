<?php
require '../../conexion.php';

// Verificar si se recibe el ID del administrador
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $idAdmin = $_GET['id'];

    // Preparar la consulta para eliminar el administrador
    $query = "DELETE FROM admins WHERE codigo = ?";
    
    // Preparar la consulta para evitar inyecciones SQL
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("i", $idAdmin);  // 'i' indica un entero
        
        // Ejecutar la consulta
        if ($stmt->execute()) {
            $mensaje = 'Administrador eliminado correctamente.';
            $url = "../../../pages/login/admin.php"; // Redirigir a la página de administración
            header("Location: $url?mensaje=" . urlencode($mensaje));
            exit;
        } else {
            echo "<p>Error al eliminar el administrador: " . $stmt->error . "</p>";
        }

        $stmt->close();
    } else {
        echo "<p>Error al preparar la consulta: " . $conn->error . "</p>";
    }
} else {
    echo "<p>ID de administrador no válido.</p>";
}

// Cerrar la conexión a la base de datos
$conn->close();
?>
