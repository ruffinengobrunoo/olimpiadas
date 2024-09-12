<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión - Administración</title>
    <link rel="stylesheet" href="../css/login.css"> <!-- Asegúrate de que el archivo CSS exista y esté en la ruta correcta -->
</head>
<body>

    <div class="container">
    <a href="paginaprincipal.html">
                <img src="../img/logo/logoHEADER.jpeg" alt="Logo">
    </a>
        <div class="login-content">
            <form method="POST" action="">
                <h2 class="title">BIENVENIDO</h2>
                <?php
                include("db.php");
                include("controlarLOGIN.php");
                ?>
                <div class="input-div one">
                    <div class="i">
                        <i class="fas fa-user"></i>
                    </div>
                    <div>
                        <h5>Usuario</h5>
                        <input type="text" class="input" name="usuario">
                    </div>
                </div>
                <div class="input-div pass">
                    <div class="i">
                        <i class="fas fa-lock"></i>
                    </div>
                    <div>
                        <h5>Contraseña</h5>
                        <input type="password" class="input" name="password">
                    </div>
                    
                </div>

                <div class="input-div one">
                    <div class="i">
                        <i class="fas fa-user"></i>
                    </div>

                <button name="ingresar" type="submit" class="btn">Ingresar</button>
               
                <div class="register-link">
                <p>¿No tienes una cuenta? <a href="../html/registro.html" class="btn-register">Regístrate</a></p>
            </div>
            </form>
        </div>
    </div>

   

</body>
</html>