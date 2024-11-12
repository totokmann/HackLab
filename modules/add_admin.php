<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = ($_POST['password']);
    $rol_id = 1;

    $sql = "INSERT INTO user (name, email, username, password, rol_id) VALUES (?, ?, ?, ?, 2)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $name, $email, $username, $password);

    if ($stmt->execute()) {
        echo "<div class='success-message'>Administrador creado exitosamente.</div>";
    } else {
        echo "<div class='error-message'>Error al crear el administrador.</div>";
    }
    $stmt->close();
}
?>

<div class="login-container-admin">
    <form method="POST" class="login-form-admin">
        <h2>Crear Administrador</h2>
        <div class="form-group-admin">
            <input type="text" name="name" placeholder="Nombre completo" required>
        </div>
        <div class="form-group-admin">
            <input type="email-admin" name="email" placeholder="Correo electrónico" required>
        </div>
        <div class="form-group-admin">
            <input type="text" name="username" placeholder="Nombre de usuario" required>
        </div>
        <div class="form-group-admin">
            <input type="password" name="password" placeholder="Contraseña" required>
        </div>
        <button type="submit" class="btn-admin">Crear Administrador</button>
    </form>
</div>
