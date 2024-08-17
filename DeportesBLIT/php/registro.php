<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $direction = $_POST['direction'];  // Obtener el valor de 'direction' desde el formulario
    $role = 'customer';  // Por defecto, el usuario es un cliente

    // Preparar la consulta para insertar los datos en la base de datos
    $stmt = $conn->prepare("INSERT INTO users (username, password, direction, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $password, $direction, $role);

    // Ejecutar la consulta y comprobar si fue exitosa
    if ($stmt->execute()) {
        echo "Registro exitoso. <a href='login.html'>Iniciar sesión</a>";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Cerrar la declaración y la conexión
    $stmt->close();
    $conn->close();
}
?>

?>