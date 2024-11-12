<?php
include 'conexion/user_info.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
    <div class="admin-container">
        <!-- Contenido Principal -->
        <div class="main-content">
            <header class="info-box admin-header">
                <h1>Panel de Administración</h1>
                <p>Bienvenido, Admin. Usa el menú de navegación para gestionar el sistema.</p>
            </header>
            <div class="info-box admin-module">
                <?php
                if(!empty($_GET['modulo']))
                {
                    include('modules/'.$_GET['modulo'].'.php');
                } 
                ?>
            </div>
        </div>
        
        <!-- Barra de Navegación a la Derecha -->
        <nav class="navbar admin-navbar">
            <div class="navbar-logout">
                <a href="funciones/logout.php">
                    <button type="button">Logout</button>
                </a>
                <span> Bienvenido, Admin!</span>
            </div>
            <!-- Menú de Opciones -->
            <ul class="admin-menu">
                <li><a href="index_admin.php?modulo=add_admin">Añadir nuevo administrador</a></li>
                <li><a href="index_admin.php?modulo=add_lab">Añadir nuevo lab</a></li>
                <li><a href="index_admin.php?modulo=edit_lab">Editar un lab</a></li>
                <li><a href="index_admin.php?modulo=add_type">Agregar un nuevo tipo de lab</a></li>
            </ul>
        </nav>
    </div>
</body>
</html>
