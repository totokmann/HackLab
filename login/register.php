<?php
include '../conexion/connection.php';

// Initialize error message variable
$error_message = "";

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if passwords match
    if ($password !== $confirm_password) {
        $error_message = "Las contraseñas no coinciden.";
    } else {
        // Check if username is already taken
        $check_username = "SELECT * FROM user WHERE username = ?";
        $stmt_check_username = $conn->prepare($check_username);
        $stmt_check_username->bind_param("s", $username);
        $stmt_check_username->execute();
        $result_username = $stmt_check_username->get_result();

        if ($result_username->num_rows > 0) {
            $error_message = "El nombre de usuario ya está registrado.";
        } else {
            // Check if email is already taken
            $check_email = "SELECT * FROM user WHERE email = ?";
            $stmt_check_email = $conn->prepare($check_email);
            $stmt_check_email->bind_param("s", $email);
            $stmt_check_email->execute();
            $result_email = $stmt_check_email->get_result();

            if ($result_email->num_rows > 0) {
                $error_message = "El correo electrónico ya está registrado.";
            } else {
                // Prepare the query to insert a new user
                $register = "INSERT INTO user (name, username, email, password) VALUES (?, ?, ?, ?)";
                $stmt_register = $conn->prepare($register);
                $stmt_register->bind_param("ssss", $name, $username, $email, $password);

                if ($stmt_register->execute()) {
                    echo "<p class='success-message'>Registro exitoso. Redirigiendo a login...</p>";
                    echo "<script>
                        setTimeout(function() {
                            window.location.href = 'login.php';
                        }, 3000);
                    </script>";
                    exit();
                } else {
                    $error_message = "Error al registrar: " . $stmt_register->error;
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HackLab - Registro</title>
    <link rel="stylesheet" href="../css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="login-container">
        <?php if ($error_message): ?>
            <p class="error-message"><?php echo $error_message; ?></p>
        <?php endif; ?>

        <form class="login-form" method="POST">
            <input type="hidden" id="form-hidden" name="form-hidden" value="visible">
            <h2>Registro</h2>

            <div class="form-group">
                <label for="name"><i class="fa fa-user"></i></label>
                <input type="text" id="name" name="name" placeholder="Nombre Completo" required>
            </div>

            <div class="form-group">
                <label for="username"><i class="fa fa-user"></i></label>
                <input type="text" id="username" name="username" placeholder="Nombre de Usuario" required>
            </div>

            <div class="form-group">
                <label for="email"><i class="fa fa-envelope"></i></label>
                <input type="email" id="email" name="email" placeholder="Correo Electrónico" required>
            </div>

            <div class="form-group">
                <label for="password"><i class="fa fa-lock"></i></label>
                <input type="password" id="password" name="password" placeholder="Contraseña" required>
            </div>

            <div class="form-group">
                <label for="confirm_password"><i class="fa fa-lock"></i></label>
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirmar Contraseña" required>
            </div>

            <button type="submit">Registrarse</button>
        </form>
        <div class="register-link">
            <p>¿Ya tienes una cuenta? <a href="login.php">Inicia Sesion aqui</a></p>
            
        </div>
    </div>
    <script src="../js/main.js"></script>
</body>
</html>
