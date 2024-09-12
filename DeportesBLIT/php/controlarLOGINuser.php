<?php
include("db.php");

if (isset($_POST["ingresar"])) {
    if (empty($_POST["username"]) || empty($_POST["password"])) {
        echo '<div>LOS CAMPOS ESTAN VACIOS</div>';
    } else {
        $usuario = $_POST["username"];
        $clave = $_POST["password"];

        // Escapar caracteres especiales para evitar inyecciones SQL
        $usuario = $conn->real_escape_string($usuario);

        // Consulta a la tabla de usuarios
        $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($hashed_password);
            $stmt->fetch();

            // Verificar la contraseña
            if (password_verify($clave, $hashed_password)) {
                header("Location: ../html/paginaprincipal.html");
                exit();
            } else {
                echo "<div>ACCESO DENEGADO</div>";
            }
        } else {
            echo "<div>ACCESO DENEGADO</div>";
        }

        $stmt->close();
    }
}
?>