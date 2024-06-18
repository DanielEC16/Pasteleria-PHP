<?php
require '../conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['agregarProd'])) {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $categoria = $_POST['categoria'];
    $imagen_tmp = $_FILES['imagen']['tmp_name'];

    // Verificar si se subió la imagen correctamente
    if (!empty($imagen_tmp) && is_uploaded_file($imagen_tmp)) {
        $imagen_data = file_get_contents($imagen_tmp);
        
        // Validar el tipo de archivo
        $allowed_types = ['image/jpeg', 'image/png'];
        $file_info = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type = finfo_file($file_info, $imagen_tmp);
        finfo_close($file_info);

        if (!in_array($mime_type, $allowed_types)) {
            echo "<p>Error: Solo se permiten archivos JPG y PNG.</p>";
            exit;
        }
    } else {
        $imagen_data = null; // Si no se proporciona una imagen
    }

    // Preparar la consulta SQL para insertar el producto
    $query = "INSERT INTO producto (Nombre, Descripción, Precio, CantidadEnStock, Categoria, foto) VALUES (?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($query);

    // Vincular parámetros
    $stmt->bind_param("ssdiis", $nombre, $descripcion, $precio, $stock, $categoria, $imagen_data);

    if ($stmt->execute()) {
        $mensaje = 'Producto agregado correctamente.';
        $url = "../../pages/login/admin.php";
        header("Location: $url?mensaje=" . urlencode($mensaje));
        exit;
    } else {
        // Si hubo un error, mostrar el mensaje de error
        echo "<p>Error al agregar el producto: " . $stmt->error . "</p>";
    }

    // Cerrar la declaración preparada
    $stmt->close();
}

// Manejo del formulario para agregar administrador
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['agregarAdmin'])) {
    $nombreAdmin = $_POST['nombreAdmin'];
    $apellido = $_POST['apellido'];
    $correo = $_POST['correo'];
    $password = $_POST['password'];

    $query = "INSERT INTO admins (nombre, apellido, correo, password) VALUES ('$nombreAdmin', '$apellido', '$correo', '$password')";

    if (mysqli_query($conn, $query)) {
        $mensaje = 'Administrador agregado correctamente.';
        $url = "../../pages/login/admin.php"; // Ruta correcta para redirigir
        header("Location: $url?mensaje=" . urlencode($mensaje));
        exit;
    } else {
        // Si hubo un error, mostrar el mensaje de error
        echo "<p>Error al agregar el administrador: " . mysqli_error($conn) . "</p>";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['agregarCategoria'])) {
    $codigoCat = $_POST['codigo'];
    $nombreCat = $_POST['nombre'];
    $imagen_tmp = $_FILES['imagen']['tmp_name'];

    // Verificar si se subió una imagen válida
    if (!empty($imagen_tmp) && is_uploaded_file($imagen_tmp)) {
        $imagen_data = file_get_contents($imagen_tmp);
    } else {
        $imagen_data = null;
    }

    // Preparar la consulta para insertar una categoría
    $query = "INSERT INTO categoria (cod, nombre, icono) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iss", $codigoCat, $nombreCat, $imagen_data);

    if ($stmt->execute()) {
        $mensaje = 'Categoría agregada correctamente.';
        $url = "../../pages/login/admin.php";
        header("Location: $url?mensaje=" . urlencode($mensaje));
        exit;
    } else {
        // Si hubo un error, mostrar el mensaje de error
        echo "<p>Error al agregar la categoría: " . $stmt->error . "</p>";
    }

    $stmt->close(); // Cerrar la declaración preparada
}

$conn->close();
?>



