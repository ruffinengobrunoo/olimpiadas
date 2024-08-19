<?php
include("db.php");

if (isset($_POST["ingresar"])) {
    if (empty($_POST["usuario"]) || empty($_POST["password"])) {
        echo '<div>LOS CAMPOS ESTAN VACIOS</div>';
    } else {
        $usuario = $_POST["usuario"];
        $clave = $_POST["password"];

        // Escapar caracteres especiales para evitar inyecciones SQL
        $usuario = $conn->real_escape_string($usuario);
        $clave = $conn->real_escape_string($clave);

        // Consulta a la tabla admin
        $sql = $conn->query("SELECT * FROM admin WHERE usuario='$usuario' AND contraseña='$clave'");
        
        if ($sql->num_rows > 0) {
            header("Location: ../admin/admin.html");
            exit();
        } else {
            echo "<div>ACCESO DENEGADO</div>";
        }
    }
}
?>