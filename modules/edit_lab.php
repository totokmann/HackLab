<?php

$message = ""; // Variable para almacenar el mensaje

// Eliminar laboratorio
if (isset($_POST['delete'])) {
    $id = $_POST['lab_id'];
    $stmt = $conn->prepare("DELETE FROM labs WHERE labs_id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $message = "<div class='success-message'>Laboratorio eliminado exitosamente.</div>";
    } else {
        $message = "<div class='error-message'>Error al eliminar laboratorio.</div>";
    }
    $stmt->close();
}

// Actualizar laboratorio
if (isset($_POST['update'])) {
    $id = $_POST['lab_id'];
    $nombre_lab = $_POST['nombre_lab'];
    $descripcion = $_POST['descripcion'];
    $xp_otorgado = $_POST['xp_otorgado'];
    $level_necesario = $_POST['level_necesario'];
    $dificultad = $_POST['dificultad'];
    $tipo_id = $_POST['tipo_id'];

    $sql = "UPDATE labs SET nombre_lab = ?, descripcion = ?, xp_otorgado = ?, level_necesario = ?, dificultad = ?, tipo_id = ? WHERE labs_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssiiisi", $nombre_lab, $descripcion, $xp_otorgado, $level_necesario, $dificultad, $tipo_id, $id);
    if ($stmt->execute()) {
        $message = "<div class='success-message'>Laboratorio actualizado exitosamente.</div>";
    } else {
        $message = "<div class='error-message'>Error al actualizar laboratorio.</div>";
    }
    $stmt->close();
}

// Listar laboratorios
$result = $conn->query("SELECT * FROM labs");
?>

<!-- Mostrar mensaje de éxito o error si existe -->
<?php if ($message): ?>
    <?php echo $message; ?>
<?php endif; ?>

<!-- Título separado del contenedor con desplazamiento -->
<h2>Laboratorios Existentes</h2>

<!-- Contenedor con desplazamiento para la lista de laboratorios -->
<div class="lab-list-container">
    <?php while ($lab = $result->fetch_assoc()): ?>
        <div class="login-container-admin">
            <form method="POST" class="login-form-admin">
                <input type="hidden" name="lab_id" value="<?php echo $lab['labs_id']; ?>">
                <div class="form-group-admin">
                    <input type="text" name="nombre_lab" value="<?php echo $lab['nombre_lab']; ?>" required>
                </div>
                <div class="form-group-admin">
                    <textarea name="descripcion" required><?php echo $lab['descripcion']; ?></textarea>
                </div>
                <div class="form-group-admin">
                    <input type="number" name="xp_otorgado" value="<?php echo $lab['xp_otorgado']; ?>" required>
                </div>
                <div class="form-group-admin">
                    <input type="number" name="level_necesario" value="<?php echo $lab['level_necesario']; ?>" required>
                </div>
                <div class="form-group-admin">
                    <input type="text" name="dificultad" value="<?php echo $lab['dificultad']; ?>" required>
                </div>
                <div class="form-group-admin">
                    <select name="tipo_id" required>
                        <?php
                        $tipo_result = $conn->query("SELECT tipo_id, vulnerabilidad FROM tipo");
                        while ($tipo = $tipo_result->fetch_assoc()) {
                            $selected = $tipo['tipo_id'] == $lab['tipo_id'] ? 'selected' : '';
                            echo "<option value='{$tipo['tipo_id']}' $selected>{$tipo['vulnerabilidad']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <button type="submit" name="update" class="btn-admin">Actualizar</button>
                <button type="submit" name="delete" class="btn-admin">Eliminar</button>
            </form>
        </div>
    <?php endwhile; ?>
</div>

