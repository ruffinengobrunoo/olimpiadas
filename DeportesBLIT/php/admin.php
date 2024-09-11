<?php
include 'db.php'; // Archivo para conectar a la base de datos

// Función para obtener la lista de productos
function getProducts($conn) {
    $result = $conn->query("SELECT id_articulo, nombre FROM articulos");
    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
    return $products;
}

$products = getProducts($conn); // Cargar productos una vez

// Añadir Producto
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
    // Obtener los datos enviados desde el formulario
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $descripcion = $_POST['descripcion'];
    $stock = $_POST['stock'];
    $imagen = $_POST['imagen'];

    // Validar que los campos no estén vacíos
    if (!empty($nombre) && !empty($precio) && !empty($descripcion) && !empty($stock) && !empty($imagen)) {
        // Preparar la consulta para evitar SQL injection
        $sql = "INSERT INTO articulos (nombre, precio, descripcion, stock, imagen) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sdsis", $nombre, $precio, $descripcion, $stock, $imagen);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            // Redirigir para evitar duplicación en caso de recargar la página
            header("Location: ".$_SERVER['PHP_SELF']);
            exit;
        } else {
            echo "Error al añadir el producto: " . $conn->error;
        }

        $stmt->close();
    } else {
        echo "Todos los campos son obligatorios.";
    }
}


// Editar Producto
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit'])) {
    $id_articulo = $_POST['id_articulo'];
    $atributo = $_POST['atributo'];
    $nuevo_valor = $_POST['nuevo_valor'];

    $sql = "UPDATE articulos SET $atributo = ? WHERE id_articulo = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $nuevo_valor, $id_articulo);

    if ($stmt->execute()) {
        echo "Producto actualizado con éxito.";
    } else {
        echo "Error al actualizar el producto: " . $conn->error;
    }

    $stmt->close();
}

// Eliminar Producto
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $id_articulo = $_POST['id_articulo'];

    $sql = "DELETE FROM articulos WHERE id_articulo = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_articulo);

    if ($stmt->execute()) {
        echo "Producto eliminado con éxito.";
    } else {
        echo "Error al eliminar el producto: " . $conn->error;
    }

    $stmt->close();
    // Recargar la lista de productos
    $products = getProducts($conn);
}

$conn->close(); // Cerrar la conexión después de todas las operaciones
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Administrar Productos</title>
    <link rel="stylesheet" href="styles.css"> <!-- Incluye aquí tu archivo CSS -->
</head>
<body>

<div>
    <h2>Añadir Producto</h2>
    <form method="POST" action="">
        <input type="text" name="nombre" placeholder="Nombre del producto" required>
        <input type="number" step="0.01" name="precio" placeholder="Precio del producto" required>
        <textarea name="descripcion" placeholder="Descripción" required></textarea>
        <input type="number" name="stock" placeholder="Stock" required>
        <input type="text" name="imagen" placeholder="URL de la imagen" required>
        <button type="submit" name="add">Añadir</button>
    </form>
</div>
<!-- Formulario para Editar Producto -->
<div>
    <h2>Editar</h2>
    <form method="POST" action="">
        <select name="id_articulo">
            <?php foreach ($products as $product): ?>
                <option value="<?= $product['id_articulo'] ?>"><?= $product['nombre'] ?></option>
            <?php endforeach; ?>
        </select>
        <select name="atributo">
            <option value="precio">Precio</option>
            <option value="descripcion">Descripción</option>
            <option value="stock">Stock</option>
            <option value="imagen">Imagen</option>
        </select>
        <input type="text" name="nuevo_valor" placeholder="Nuevo valor" required>
        <button type="submit" name="edit">Editar</button>
    </form>
</div>

<!-- Formulario para Eliminar Producto -->
<div>
    <h2>Eliminar</h2>
    <form method="POST" action="">
        <select name="id_articulo">
            <?php foreach ($products as $product): ?>
                <option value="<?= $product['id_articulo'] ?>"><?= $product['nombre'] ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit" name="delete">Eliminar</button>
    </form>
</div>

</body>
</html>