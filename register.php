<?php
// Incluye el archivo de conexión.
require "conexion.php";
//variable
$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    //Comprueba si el formulario fue enviado.
    $nombre = trim($_POST["nombre"]);
    $email = trim($_POST["email"]);
    $contrasena = $_POST["contrasena"];
    //trae lo que el usuario escribió en el campo


if ($nombre === "" || $email === "" || $contrasena === "") {
    $mensaje = "Completa todo los campos.";
}
//Verifica que el texto tenga formato de email
elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)){
    $mensaje = "El email no es valido";
}
//Convierte la contraseña en un hash (un texto largo irreversible). Eso es lo que se guarda en la base de datos, nunca la contraseña real.
else{
    $hash = password_hash($contrasena, PASSWORD_DEFAULT);
    
    //Prepara la consulta con cuatro ? como espacios vacíos. Los datos del usuario no se pegan en el texto SQL, así nadie puede inyectar código malicioso.
    $stmt = $conexion->prepare(


        "INSERT INTO usuarios (nombre, email, password_hash, contrasena) VALUES (?, ?, ?, ?)"); //Rellena los tres ? con las variables, en orden. "sss" indica que los tres son strings (texto). Si hubiera un número entero sería i, por ejemplo "ssi".
    $stmt->bind_param("ssss", $nombre, $email, $hash, $contrasena);

    try{
        $stmt->execute();
        header("Location: index.html");
        $mensaje = "Usuario Registrado correctamente";
    exit();
    }
    catch (mysqli_sql_exception $e){
        $mensaje = "Ese email ya esta registrado.";
    }
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrate</title>
    <link rel="stylesheet" href="css/inicio.css">
</head>
<body class="page-login">
    <div class="split-container">
        <div class="left-side">
                <a href="login.html" class="boton-volver">Volver</a>
                <h1>¡Hola!</h1>
        </div>
        <div class="right-side">
            <div class="login-box">
                <h2>BODEGA<br><span style="font-size: 1.5rem;">Las Alturas</span></h2>
                <h3>Registrate</h3>

        <?php if ($mensaje !== ""): ?>
        <?php echo htmlspecialchars($mensaje); ?>
        <?php endif; ?>
    
        <form action="register.php" method="post">
    <label for="nombre">Nombre/Usuario</label>
    <input type="text" id="nombre" name="nombre" placeholder="Ingresa un nombre" required>

    <label for="email">Correo Electronico</label>
    <input type="email" id="email" name="email" placeholder="abcd@gmail.com" required>

    <label for="contrasena">Contraseña</label>
    <input type="password" id="contrasena" name="contrasena" placeholder="contraseña" required>

    <div class="footer-login">
        <button type="submit" class="btn-login">Registrate</button>
    </div>
</form>
        </div> <!-- cierra login-box -->
    </div> <!-- cierra right-side -->
</div> <!-- cierra split-container -->
</body>
</html>
</body>
</html>

