<?php
include '../conexion/connection.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hacklab - Login</title>
    <link rel="stylesheet" href="../css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="login-container">
        <form class="login-form" action="" method="POST">
            <h2>Login</h2>
            <div class="form-group">
                <label for="username"><i class="fa fa-user"></i></label>
                <input type="text" id="username" name="username" placeholder="Nombre de Usuario" required>
            </div>
            <div class="form-group">
                <label for="password"><i class="fa fa-lock"></i></label>
                <input type="password" id="password" name="password" placeholder="Contraseña" required>
            </div>
            <button type="submit">Ingresar</button>
        </form>

        <!-- Mensaje de error debajo del formulario -->
        <?php
        // Verificar si se ha enviado el formulario
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            // Verificar el usuario
            $sql = "SELECT * FROM user WHERE username = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();
                if ($password === $user['password']) {
                    $update = "UPDATE user SET logged_in = 1 WHERE user_id = ?";
                    $stmt = $conn->prepare($update);
                    $stmt->bind_param("i", $user['user_id']);
                    $stmt->execute();

                    $insert = "INSERT INTO login_history (user_id, login_time) VALUES (?, NOW())";
                    $stmt = $conn->prepare($insert);
                    $stmt->bind_param("i", $user['user_id']);
                    $stmt->execute();

                    session_start();
                    $_SESSION['user_id'] = $user['user_id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['name'] = $user['name'];
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['xp_total'] = $user['xp_total'];
                    $_SESSION['rol_id'] = $user['rol_id'];
                    
                    header("Location: ../index.php"); 
                    exit();
                } else {
                    echo "<p class='error-message'>Contraseña incorrecta</p>";
                }
            } else {
                echo "<p class='error-message'>Usuario no encontrado</p>";
            }
        }
        ?>

        <div class="register-link">
            <p>¿No tienes una cuenta? <a href="register.php">Regístrate aquí</a></p>
        </div>
    </div>
</body>
</html>
