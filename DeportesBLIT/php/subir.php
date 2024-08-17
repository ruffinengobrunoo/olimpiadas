<?php //NO FUNCIONAL
include 'db.php'; // Incluye la conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recoge los datos del formulario
    $category = $_POST['category'];
    $name = $_POST['name'];
    $stock = $_POST['stock'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    // Manejo de la imagen
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = $_FILES['image'];
        $imageName = time() . "_" . basename($image['name']);
        $targetDir = "uploads/";
        $targetFile = $targetDir . $imageName;

        // Mueve el archivo subido al directorio de destino
        if (move_uploaded_file($image['tmp_name'], $targetFile)) {
            // Prepara la consulta SQL
            $stmt = $conn->prepare("INSERT INTO productos (nombre_art, stock, precio, descripcion, imagen, categoria) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sissss", $name, $stock, $price, $description, $targetFile, $category);

            // Ejecuta la consulta y verifica el resultado
            if ($stmt->execute()) {
                echo "Producto añadido correctamente.";
            } else {
                echo "Error al añadir el producto: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Error al subir la imagen.";
        }
    } else {
        echo "No se ha seleccionado ninguna imagen.";
    }

    $conn->close();
}
?>
