<?php
include 'db.php';

// Obtener los datos del formulario
$id_orden = $_POST['id_orden'] ?? null;
$accion = $_POST['accion'] ?? null;

if ($id_orden && $accion) {
    if ($accion === 'aceptar') {
        // Consultar detalles de la orden
        $query = "SELECT id_articulo, cantidad FROM detalles_orden WHERE id_orden = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id_orden);
        $stmt->execute();
        $result = $stmt->get_result();

        // Actualizar el stock de los productos
        while ($detalle = $result->fetch_assoc()) {
            $id_articulo = $detalle['id_articulo'];
            $cantidad = $detalle['cantidad'];

            // Obtener stock actual
            $query = "SELECT stock FROM articulos WHERE id_articulo = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $id_articulo);
            $stmt->execute();
            $stock_result = $stmt->get_result();
            $stock = $stock_result->fetch_assoc()['stock'];

            // Restar la cantidad del stock
            $nuevo_stock = $stock - $cantidad;
            $query = "UPDATE articulos SET stock = ? WHERE id_articulo = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ii", $nuevo_stock, $id_articulo);
            $stmt->execute();
        }

        // Actualizar el estado de la orden
        $query = "UPDATE ordenes SET estado = 'Aceptado' WHERE id_orden = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id_orden);
        $stmt->execute();
    } elseif ($accion === 'rechazar') {
        // Consultar detalles de la orden
        $query = "SELECT id_articulo, cantidad FROM detalles_orden WHERE id_orden = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id_orden);
        $stmt->execute();
        $result = $stmt->get_result();

        // Devolver el stock de los productos
        while ($detalle = $result->fetch_assoc()) {
            $id_articulo = $detalle['id_articulo'];
            $cantidad = $detalle['cantidad'];

            // Obtener stock actual
            $query = "SELECT stock FROM articulos WHERE id_articulo = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $id_articulo);
            $stmt->execute();
            $stock_result = $stmt->get_result();
            $stock = $stock_result->fetch_assoc()['stock'];

            // Aumentar la cantidad del stock
            $nuevo_stock = $stock + $cantidad;
            $query = "UPDATE articulos SET stock = ? WHERE id_articulo = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ii", $nuevo_stock, $id_articulo);
            $stmt->execute();
        }

        // Actualizar el estado de la orden
        $query = "UPDATE ordenes SET estado = 'Rechazado' WHERE id_orden = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id_orden);
        $stmt->execute();
    }

    // Redirigir de vuelta a la página de administración de órdenes
    header("Location: admin.php");
    exit;
} else {
    echo "Datos inválidos.";
}
