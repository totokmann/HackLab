<?php
function obtenerNivel($xp_total, $conn) {
    $obtainlevel = "SELECT nombre, level_id, xp_necesario FROM level WHERE xp_necesario <= ? ORDER BY xp_necesario DESC LIMIT 1";
    $stmt = $conn->prepare($obtainlevel);
    $stmt->bind_param("i", $xp_total);
    $stmt->execute();
    $result = $stmt->get_result();
    $nivel = $result->fetch_assoc();
    return $nivel;
}

function calcularPorcentajeXP($xp_total, $conn) {
    $query = "SELECT xp_necesario FROM level WHERE xp_necesario > ? ORDER BY xp_necesario ASC LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $xp_total);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $next_level = $result->fetch_assoc();
        $xp_maximo = $next_level['xp_necesario'];
        $porcentaje_xp = ($xp_total / $xp_maximo) * 100;
        return ['porcentaje' => min($porcentaje_xp, 100), 'xp_maximo' => $xp_maximo];
    } else {
        return ['porcentaje' => 100, 'xp_maximo' => $xp_total];
    }
}

?>
