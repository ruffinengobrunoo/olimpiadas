<?php
include 'db.php';  // Incluir archivo de conexión a la base de datos

// Función para obtener los detalles de una orden específica
function getOrderDetails($conn, $id_orden) {
    $query = "
        SELECT a.nombre, do.cantidad, do.precio 
        FROM detalles_orden do
        JOIN articulos a ON do.id_articulo = a.id_articulo
        WHERE do.id_orden = ?";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_orden);
    $stmt->execute();
    $result = $stmt->get_result();

    $detalles = [];
    while ($row = $result->fetch_assoc()) {
        $detalles[] = $row;
    }

    return $detalles;
}

// Obtener el ID de la orden de la URL o del formulario
$id_orden = $_GET['id_orden'] ?? null;

if ($id_orden) {
    // Obtener los detalles de la orden
    $detalles_orden = getOrderDetails($conn, $id_orden);
    
    // Mostrar los detalles
    echo "<h3>Detalles de la Orden #{$id_orden}</h3>";
    foreach ($detalles_orden as $detalle) {
        echo "<p>Producto: {$detalle['nombre']} | Cantidad: {$detalle['cantidad']} | Precio: {$detalle['precio']}</p>";
    }
} else {
    echo "No se proporcionó un ID de orden válido.";
}
?>
