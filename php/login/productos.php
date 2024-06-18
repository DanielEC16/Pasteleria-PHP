<form method="POST" enctype="multipart/form-data">
    <label for="">Nombre</label>
    <input type="text" name="nombre">
    <label for="">Descripción</label>
    <input type="text" name="descripcion">
    <label for="">Precio</label>
    <input type="number" name="precio">
    <label for="">Stock</label>
    <input type="number" name="stock">
    <label for="">Categoría</label>
    <select id="categoria" name="categoria">
        <?php
        include '../conexion.php';

        // Consulta para obtener las categorías disponibles
        $query = "SELECT cod, nombre FROM categoria";
        $result = $conn->query($query);

        // Generar las opciones del select con las categorías
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['cod'] . "'>" . $row['nombre'] . "</option>";
        }

        // Cerrar la conexión
        $conn->close();
        ?>
    </select>
    <label for="">Imagen</label>
    <input type="file" name="imagen">
    <button type="submit" name="proceso" value="agregarProd">Agregar Producto</button>
</form>

<?php
include '../conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['proceso']) && $_POST['proceso'] == 'agregarProd') {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $categoria = $_POST['categoria'];
    $imagen_tmp = $_FILES['imagen']['tmp_name'];

    // Verifica si se subió una imagen
    if (!empty($imagen_tmp)) {
        $imagen_data = file_get_contents($imagen_tmp);
    } else {
        $imagen_data = null;
    }

    // Preparar la consulta SQL con marcadores de posición
    $query = "INSERT INTO Producto (Nombre, Descripción, Precio, CantidadEnStock, Categoria, foto) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);

    // Vincular parámetros y ejecutar la consulta
    $stmt->bind_param("ssdiss", $nombre, $descripcion, $precio, $stock, $categoria, $imagen_data);
    
    if ($stmt->execute()) {
        echo "<p>Producto agregado correctamente.</p>";
    } else {
        echo "<p>Error al agregar el producto.</p>";
    }

    $stmt->close();
}

// Mostrar productos después de insertar uno nuevo
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

$conn->close();
?>
