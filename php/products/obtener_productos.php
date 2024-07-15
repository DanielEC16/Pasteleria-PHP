<?php
require '../conexion.php';

// Verificar si se recibió el parámetro de categoría por GET
if (isset($_GET['categoria'])) {
    $categoria = $_GET['categoria'];

    // Consulta para obtener productos por categoría
    if ($categoria === 'Todo') {
        // Si se selecciona 'Todo', mostrar todos los productos
        $query = "SELECT p.* FROM producto p";
        $stmt = $conn->prepare($query);
    } else {
        // Si se selecciona una categoría específica, filtrar por esa categoría
        $query = "SELECT p.* 
                  FROM producto p 
                  JOIN categoria c ON p.Categoria = c.cod 
                  WHERE c.nombre = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $categoria);
    }


    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="card">';
                echo '<img src="data:image/png;base64,' . base64_encode($row['foto']) . '" alt="Imagen del producto">';
                echo '<div class="info">';
                echo '<h3>' . $row['Nombre'] . '</h3>';
                echo '<p>' . $row['Descripción'] . '</p>';
                echo '</div>';
                echo '<div class="price">S/. ' . number_format($row['Precio'], 2) . '</div>';
                echo '<button class="btn-add-cart" data-id="' . $row['ID'] . '">Agregar al carrito <i class="fa-solid fa-circle-plus"></i></button>';
                echo '</div>';
            }
        } else {
            echo "<p>No se encontraron productos para la categoría '$categoria'.</p>";
        }
    } else {
        echo "Error al ejecutar la consulta: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "No se recibió la categoría correctamente.";
}

$conn->close();
?>
