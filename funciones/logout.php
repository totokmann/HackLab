<?php
include '../conexion/connection.php';

$update_logout = "UPDATE user SET logged_in = 0 WHERE user_id = ?";
$stmt = $conn->prepare($update_logout);
$stmt->bind_param("i", $user_id);
$stmt->execute();

session_unset();
session_destroy();
header("Location: ../login/login.php");
exit();
?>