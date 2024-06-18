<?php
require '../conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['modifiProd'])) {
    // Obtener los datos del formulario
    $producto_id = $_POST['producto_id'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $categoria = $_POST['categoria'];

    // Manejar la imagen si se envía una nueva
    if ($_FILES['imagen']['size'] > 0) {
        $imagen = $_FILES['imagen']['tmp_name'];
        $imagenContenido = addslashes(file_get_contents($imagen));
        $query = "UPDATE producto SET Nombre='$nombre', Descripción='$descripcion', Precio='$precio', CantidadEnStock='$stock', Categoria='$categoria', foto='$imagenContenido' WHERE ID='$producto_id'";
    } else {
        // Si no se envía una nueva imagen, omitir el campo 'foto' en la actualización
        $query = "UPDATE producto SET Nombre='$nombre', Descripción='$descripcion', Precio='$precio', CantidadEnStock='$stock', Categoria='$categoria' WHERE ID='$producto_id'";
    }

    // Conectar a la base de datos
    // Asegúrate de incluir el archivo correcto aquí

    // Ejecutar la consulta SQL
    if ($conn->query($query) === TRUE) {
        $mensaje = 'Producto modificado correctamente.';
        $url = "../../pages/login/admin.php"; // Ruta correcta para redirigir
        header("Location: $url?mensaje=" . urlencode($mensaje));
        exit;
    } else {
        echo "Error al actualizar el producto: " . $conn->error;
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['modifiAdmin'])) {
    $admin_id = $_POST['admin_id'];
    $nombre = $_POST['nombreAdmin'];
    $apellido = $_POST['apellido'];
    $correo = $_POST['correo'];
    $password = $_POST['password'];

    // Actualizar el administrador en la base de datos
    $query = "UPDATE admins SET nombre='$nombre', apellido='$apellido', correo='$correo', password='$password' WHERE codigo=$admin_id";

    if ($conn->query($query) === TRUE) {
        $mensaje = "Los datos del administrador se actualizaron correctamente.";
        $url = "../../pages/login/admin.php"; // Ruta correcta para redirigir
        header("Location: $url?mensaje=" . urlencode($mensaje));
        exit;
    } else {
        echo "Error al actualizar los datos del administrador: " . $conn->error;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['modificarCategoria'])) {

    // Obtener los datos del formulario
    $categoria_id = $_POST['categoria_id'];
    $nuevo_nombre = $_POST['nombreCategoria'];

    // Manejar la imagen si se envía una nueva
    if ($_FILES['imagenCategoria']['size'] > 0) {
        $imagen = $_FILES['imagenCategoria']['tmp_name'];
        $imagenContenido = file_get_contents($imagen);
        $query = "UPDATE categoria SET nombre=?, icono=? WHERE cod=?";

        // Preparar la consulta
        $stmt = $conn->prepare($query);
        if ($stmt === false) {
            echo "Error en la preparación de la consulta.";
        } else {
            // Bind de parámetros y ejecución de la consulta
            $stmt->bind_param('ssi', $nuevo_nombre, $imagenContenido, $categoria_id);
            if ($stmt->execute()) {
                $mensaje = 'Categoría modificada correctamente.';
                $url = "../../pages/login/admin.php"; // Ruta correcta para redirigir
                header("Location: $url?mensaje=" . urlencode($mensaje));
                exit;
            } else {
                echo "Error al actualizar la categoría: " . $conn->error;
            }
        }
        $stmt->close();
    } else {
        // Si no se envía una nueva imagen, solo actualizar el nombre
        $query = "UPDATE categoria SET nombre=? WHERE cod=?";

        // Preparar la consulta
        $stmt = $conn->prepare($query);
        if ($stmt === false) {
            echo "Error en la preparación de la consulta.";
        } else {
            // Bind de parámetros y ejecución de la consulta
            $stmt->bind_param('si', $nuevo_nombre, $categoria_id);
            if ($stmt->execute()) {
                $mensaje = 'Categoría modificada correctamente.';
                $url = "../../pages/login/admin.php"; // Ruta correcta para redirigir
                header("Location: $url?mensaje=" . urlencode($mensaje));
                exit;
            } else {
                echo "Error al actualizar la categoría: " . $conn->error;
            }
        }
        $stmt->close();
    }
}
$conn->close();
