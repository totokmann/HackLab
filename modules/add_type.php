<?php
// Verificar si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $vulnerabilidad = $_POST['vulnerabilidad'];

    // Insertar el nuevo tipo en la base de datos
    $sql = "INSERT INTO tipo (vulnerabilidad) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $vulnerabilidad);

    if ($stmt->execute()) {
        echo "<div class='success-message'>Tipo de laboratorio agregado exitosamente.</div>";
    } else {
        echo "<div class='error-message'>Error al agregar el tipo de laboratorio.</div>";
    }
    $stmt->close();
}
?>

<div class="login-container-admin">
    <form method="POST" class="login-form-admin">
        <h2>Agregar Tipo de Laboratorio</h2>
        <div class="form-group-admin">
            <input type="text" name="vulnerabilidad" placeholder="Nombre del tipo de laboratorio" required>
        </div>
        <button type="submit" class="btn-admin">Agregar Tipo</button>
    </form>
</div>
