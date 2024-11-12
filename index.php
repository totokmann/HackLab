<?php
include 'conexion/user_info.php';

if (!isset($_SESSION['user_id']) || $_SESSION['rol_id'] == '2') {
    header("Location: index_admin.php");
    exit();
}

$xp_total = $_SESSION['xp_total'];
$xp_data = calcularPorcentajeXP($xp_total, $conn);

$porcentaje_xp = $xp_data['porcentaje'];
$xp_maximo = $xp_data['xp_maximo'];

// Obtener el level_id del usuario actual
$query_user_level = "SELECT level_id FROM user WHERE user_id = ?";
$stmt_user_level = $conn->prepare($query_user_level);
$stmt_user_level->bind_param("i", $user_id);
$stmt_user_level->execute();
$user_level = $stmt_user_level->get_result()->fetch_column();

// Obtener los niveles
$query_levels = "SELECT level_id, nombre FROM level";
$stmt_levels = $conn->prepare($query_levels);
$stmt_levels->execute();
$result = $stmt_levels->get_result();
$levels = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>HackLab</title>
    <link rel='stylesheet' href='css/inicio.css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <nav class="navbar">
        <div class="navbar-logout">
            <a href="funciones/logout.php">
                <button type="button">Logout</button>
            </a>
            <span> Welcome <?php echo $name ?>!</span>
        </div>
        <div class="navbar-search">
            <input type="text" placeholder="Search...">
        </div>
        <button type="button" class="toggle-sidebar" onclick="toggleSidebar()">
            <i class="fa fa-bars"></i>
        </button>
    </nav>

    <div class="container">
        <aside class="sidebar" id="sidebar">
            <div class="levels">
                <h2>Levels</h2>
                <ul>
                    <?php foreach ($levels as $level): ?>
                        <li <?php if ($level['level_id'] == $user_level) echo 'class="current-level"'; ?>>
                            <a>
                                <?php echo htmlspecialchars($level['nombre']); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="options">
                <h2>Options</h2>
                <ul>
                    <li><a href="index.php?modulo=home">Home</a></li>
                    <li><a href="index.php?modulo=listado_box">All products box</a></li>
                    <li><a href="index.php?modulo=listado_tabla">All products table</a></li>
                </ul>
            </div>
        </aside>
        <main class="main-content">
            <div class="info-boxes">
                <div class="info-box">
                    <div class="level-tag"><?php echo $username; ?></div>
                    <h3><?php echo $user_data['nombre'];; ?></h3>
                    <div class="progress-container">
                        <div id="progress-bar" class="progress-bar" style="width: <?php echo round($porcentaje_xp); ?>%"></div>
                        <?php echo round($porcentaje_xp); ?>%
                    </div>
                    <?php echo $xp; ?>/<?php echo $xp_maximo; ?>
                </div>
            </div>
            <div class="info-box">
                <?php
                if (empty($_GET['modulo'])) {
                    include('modules/home.php');
                } else {
                    include('modules/' . $_GET['modulo'] . '.php');
                }
                ?>
            </div>
        </main>
    </div>
    <footer class="footer">
        <div class="footer-content">
            <p>© 2024 HackLab</p>
            <p>Contact us: contact@hacklab.com</p>
        </div>
    </footer>
    <script src="js/main.js"></script>
</body>

</html>