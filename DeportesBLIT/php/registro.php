<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $direction = $_POST['direction'];  // Obtener el valor de 'direction' desde el formulario
      // Por defecto, el usuario es un cliente

    // Preparar la consulta para insertar los datos en la base de datos
    $stmt = $conn->prepare("INSERT INTO users (username, password, direction) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $password, $direction);

    // Ejecutar la consulta y comprobar si fue exitosa
    if ($stmt->execute()) {
        echo "Registro exitoso. <a href='loginusuario.php'>Iniciar sesión</a>";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Cerrar la declaración y la conexión
    $stmt->close();
    $conn->close();
}
?>
