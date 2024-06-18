<?php
// Incluir el archivo de conexión a la base de datos
require '../../conexion.php';

// Verificar si se recibió un ID válido por GET y si no está vacío
if (isset($_GET['id']) && !empty($_GET['id'])) {
    // Sanitizar y asignar el ID del producto
    $idUsuario = mysqli_real_escape_string($conn, $_GET['id']);

    // Consulta SQL para eliminar el producto
    $query = "DELETE FROM usuarios WHERE ID = $idUsuario";

    // Ejecutar la consulta y verificar si fue exitosa
    if (mysqli_query($conn, $query)) {
        // Redirigir a la página de administrador con un mensaje de éxito
        $mensaje = 'Usuario eliminado correctamente.';
        $url = "../../../pages/login/admin.php"; // Ajustar la URL según tu estructura de archivos
        header("Location: $url?mensaje=" . urlencode($mensaje));
        exit;
    } else {
        // Manejar el error si la ejecución de la consulta falla
        echo "<p>Error al eliminar el Usuario: " . mysqli_error($conn) . "</p>";
    }
} else {
    // Manejar el caso donde no se proporcionó un ID válido o está vacío
    echo "<p>ID de Usuario no válido.</p>";
}

// Cerrar la conexión a la base de datos
mysqli_close($conn);
?>
