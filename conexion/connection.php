<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

$host = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "hacklab";
$port = "3306";

// Crear conexión
$conn = new mysqli($host, $db_username, $db_password , $dbname, $port);

// Verificar conexión
if ($conn->connect_error) {
    die("No se pudo conectar a la base de datos: " . $conn->connect_error);
}