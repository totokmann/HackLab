<?php
include 'connection.php';
include __DIR__ . '/../funciones/functions.php';

// Redirect to login if the user is not logged in
if (!isset($_SESSION['username'])) {
    header("Location: ./login/login.php");
    exit();
}

// User variables
$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
$name = $_SESSION['name'];
$email = $_SESSION['email'];
$xp = $_SESSION['xp_total'];
$rol = $_SESSION['rol_id'];

// Obtener la experiencia y el nivel actual del usuario desde la base de datos
$query = "SELECT user.xp_total, user.level_id, level.nombre 
          FROM user 
          JOIN level ON user.level_id = level.level_id 
          WHERE user.user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user_data = $stmt->get_result()->fetch_assoc();

$_SESSION['xp_total'] = $user_data['xp_total'];
$_SESSION['level'] = $user_data['nombre'];
$_SESSION['level_id'] = $user_data['level_id'];

$level = $_SESSION['level'];
?>