<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_lab = $_POST['nombre_lab'];
    $descripcion = $_POST['descripcion'];
    $xp_otorgado = $_POST['xp_otorgado'];
    $level_necesario = $_POST['level_necesario'];
    $dificultad = $_POST['dificultad'];
    $tipo_id = $_POST['tipo_id'];

    $sql = "INSERT INTO labs (nombre_lab, descripcion, xp_otorgado, level_necesario, dificultad, tipo_id) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssiiis", $nombre_lab, $descripcion, $xp_otorgado, $level_necesario, $dificultad, $tipo_id);

    if ($stmt->execute()) {
        echo "<div class='success-message'>Laboratorio agregado exitosamente.</div>";
    } else {
        echo "<div class='error-message'>Error al agregar laboratorio.</div>";
    }
    $stmt->close();
}
?>

<div class="login-container-admin">
    <form method="POST" class="login-form-admin">
        <h2>Agregar Laboratorio</h2>
        <div class="form-group-admin">
            <input type="text" name="nombre_lab" placeholder="Nombre del laboratorio" required>
        </div>
        <div class="form-group-admin">
            <textarea name="descripcion" placeholder="Descripción del laboratorio" required></textarea>
        </div>
        <div class="form-group-admin">
            <input type="number" name="xp_otorgado" placeholder="XP otorgado" required>
        </div>
        <div class="form-group-admin">
            <input type="number" name="level_necesario" placeholder="Level necesario" required>
        </div>
        <div class="form-group-admin">
            <input type="text" name="dificultad" placeholder="Dificultad" required>
        </div>
        <div class="form-group-admin">
            <select name="tipo_id" required>
                <?php
                $result = $conn->query("SELECT tipo_id, vulnerabilidad FROM tipo");
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='{$row['tipo_id']}'>{$row['vulnerabilidad']}</option>";
                }
                ?>
            </select>
        </div>
        <button type="submit" class="btn-admin">Agregar Laboratorio</button>
    </form>
</div>
