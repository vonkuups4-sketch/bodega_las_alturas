<?php
// Inicia la sesión para poder guardar datos del usuario
session_start();

// Trae la conexión a la base de datos (define $conexion)
require "conexion.php";

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email      = trim($_POST["email"]);
    $contrasena = $_POST["contrasena"];

    // Busca al usuario por su email
    $stmt = $conexion->prepare(
        "SELECT id, nombre, password_hash FROM usuarios WHERE email = ?"
    );
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $usuario = $stmt->get_result()->fetch_assoc();

    // Si existe y la contraseña coincide con el hash guardado
    if ($usuario && password_verify($contrasena, $usuario["password_hash"])) {
        $_SESSION["usuario_id"] = $usuario["id"];
        $_SESSION["nombre"]     = $usuario["nombre"];
        header("Location: inicio.php");
        exit;
    } else {
        $mensaje = "Email o contraseña incorrectos.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>inicio de sesion</title>
    <link rel="stylesheet" href="css/inicio.css">
</head>
<body class="page-login">
    <div class="split-container">

        <div class="left-side">
                <a href="index.html" class="boton-volver">VOLVER AL INICIO</a>
                <h1>Bienvenidos a nuestra Bodega!</h1>
        </div>
        <div class="right-side">
            <div class="login-box">
                <h2>BODEGA<br><span style="font-size: 1.5rem;">Las Alturas</span></h2>
                <h3>INICIA SESIÓN</h3>
            
                <form action="login.php">
                    <label for="correo">Correo Electronico</label>
                    <input type="email" placeholder="abcd@gmail.com">

                    <label for="pass">Contraseña</label>
                    <input type="password" placeholder="contraseña">

                    <div class="footer-login">
                        <a href="register.html">¿No tienes cuenta?<br><strong>Registrate</strong></a>
                        <button type="submit" class="btn-login">INICIAR SESIÓN</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    

</body>
</html>