<?php
require 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['proceso'])) {
        $accion = $_POST['proceso'];
        switch ($accion) {
            case 'agregarProd':
                if (agregar($conn)) {
                    header("Location: ../../pages/login/admin.php"); // Redirige si el producto se agregó correctamente
                    exit();
                } else {
                    echo "Error al agregar el producto.";
                }
                break;
            case 'agregarAdmin':
                if (agregarAdmin($conn)) {
                    header("Location: ../../pages/login/admin.php"); // Redirige si el producto se agregó correctamente
                    exit();
                } else {
                    echo "Error.";
                }
                break;
            default:
                echo "Acción no válida.";
        }
    } else {
        echo "No se ha especificado una acción.";
    }
}

function mostrarProductos($conn)
{
    $query = "SELECT * FROM Producto";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>ID</th><th>Nombre</th><th>Descripción</th><th>Precio</th><th>Cantidad en Stock</th><th>Categoría</th><th>Imagen</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['ID'] . "</td>";
            echo "<td>" . $row['Nombre'] . "</td>";
            echo "<td>" . $row['Descripción'] . "</td>";
            echo "<td>" . $row['Precio'] . "</td>";
            echo "<td>" . $row['CantidadEnStock'] . "</td>";
            echo "<td>" . $row['Categoria'] . "</td>";
            
            // Ajusta los atributos para asegurarte de que estén entre comillas
            echo "<td><img src='data:image/jpg;base64," . base64_encode($row['foto']) . "' alt='Imagen del producto'></td>";
            echo "</tr>";
        }
        
        echo "</table>";
    } else {
        echo "No se encontraron productos.";
    }
}


function mostrarAdmins($conn){
    $query = "SELECT * FROM admins";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>ID</th><th>Nombre</th><th>Apellido</th><th>Correo</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['codigo'] . "</td>";
            echo "<td>" . $row['nombre'] . "</td>";
            echo "<td>" . $row['apellido'] . "</td>";
            echo "<td>" . $row['correo'] . "</td>";        
            echo "</tr>";
        }
        
        echo "</table>";
    } else {
        echo "No se encontraron productos.";
    }
}




function agregar($conn)
{
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $categoria = $_POST['categoria'];
    $imagen = addslashes(file_get_contents($_FILES['imagen']['tmp_name']));
    $query = "INSERT INTO Producto (Nombre, Descripción, Precio, CantidadEnStock, Categoria, foto) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssdiss", $nombre, $descripcion, $precio, $stock, $categoria, $imagen);
    
    return $stmt->execute();
}


function agregarAdmin($conn) {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $correo = $_POST['correo'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("INSERT INTO admins (Nombre, Apellido, Correo, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nombre, $apellido, $correo, $password);

    if ($stmt->execute()) {
        return true;
    } else {
        error_log("Error: " . $stmt->error); // Guardar error en log para referencia
        return false;
    }
}

?>

