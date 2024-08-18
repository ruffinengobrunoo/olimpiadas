<?php //NO FUNCIONAL
include 'db.php'; // Asegúrate de incluir el archivo de conexión a la base de datos

// Consulta para obtener productos
$query = "SELECT id_articulo, nombre_art, precio, imagen FROM productos";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    echo '<div class="product-list">';
    while ($row = $result->fetch_assoc()) {
        $imagePath = 'uploads/' . $row['imagen']; // Ruta de la imagen en el servidor
        echo '<div class="product">';
        echo '<img src="' . $imagePath . '" alt="' . htmlspecialchars($row['nombre_art']) . '">';
        echo '<h3>' . htmlspecialchars($row['nombre_art']) . '</h3>';
        echo '<p>Precio: $' . htmlspecialchars($row['precio']) . '</p>';
        echo '</div>';
    }
    echo '</div>';
} else {
    echo 'No hay productos disponibles.';
}

$conn->close();
?>
