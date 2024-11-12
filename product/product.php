<?php
include '../conexion/user_info.php';

$product_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$query = "SELECT *
          FROM labs
          INNER JOIN tipo ON labs.tipo_id = tipo.tipo_id
          WHERE labs.labs_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if (!$product) {
    echo "<h1>Producto no encontrado</h1>";
    exit();
}

$query_create_userlab = "SELECT * FROM user_labs WHERE user_id = ? AND labs_id = ?";
$stmt = $conn->prepare($query_create_userlab);
$stmt->bind_param("ii", $user_id, $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    // Si no existe el registro, insertar uno nuevo con estado "en progreso"
    $insert_query = "INSERT INTO user_labs (user_id, labs_id, estado) VALUES (?, ?, 'en progreso')";
    $insert_stmt = $conn->prepare($insert_query);
    $insert_stmt->bind_param("ii", $user_id, $product_id);
    $insert_stmt->execute();
}

$flag_correcta = "FLAG{XSS_success_123}";
$mensaje = "";

// Verificación de la flag
if (isset($_POST['flag'])) {
    $flag_ingresada = $_POST['flag'];

    if ($flag_ingresada === $flag_correcta) {
        // Marcamos el laboratorio como completado
        $query_update = "UPDATE user_labs SET estado = 'completado' WHERE user_id = ? AND labs_id = ?";
        $stmt_update = $conn->prepare($query_update);
        $stmt_update->bind_param("ii", $user_id, $product_id);
        $stmt_update->execute();
        if($rol == 1){
            // Otorgar XP al usuario
            $xp_otorgado = $product['xp_otorgado'];
            $query_xp = "UPDATE user SET xp_total = xp_total + ? WHERE user_id = ?";
            $stmt_xp = $conn->prepare($query_xp);
            $stmt_xp->bind_param("ii", $xp_otorgado, $user_id);
            $stmt_xp->execute();
            $mensaje = "¡Correcto! Laboratorio completado. Has ganado $xp_otorgado XP.";
        }
    } else {
        $mensaje = "Flag incorrecta. Inténtalo de nuevo.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['nombre_lab']); ?> - HackLab</title>
    <link rel="stylesheet" href="../css/product.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <nav class="navbar">
        <div class="navbar-back">
            <button type="button" onclick="goBack()">
                <i class="fa fa-arrow-left"></i> Back
            </button>
        </div>
        <div class="navbar-search">
            <input type="text" placeholder="Search...">
        </div>
        <div class="navbar-logout">
            <span>Welcome <?php echo $name ?>!</span>
            <a href="logout.php">
                <button type="button">Logout</button>
            </a>
        </div>
    </nav>
    <main class="main-content">
        <div class="info-box">
            <h2><?php echo htmlspecialchars($product['nombre_lab']); ?></h2>
            <p><strong>Dificultad:</strong> <?php echo htmlspecialchars($product['dificultad']); ?></p>
            <p><strong>Descripción:</strong></p>
            <p><?php echo htmlspecialchars($product['descripcion']); ?></p>

            <!-- Botón para iniciar el laboratorio -->
            <button class="play-button" onclick="redirectToPage('<?php echo htmlspecialchars($product['nombre_lab']); ?>')">Probar Ahora</button>
            
            <!-- Formulario para ingresar la flag -->
            <h3>Introduce la flag:</h3>
            <form action="product.php?id=<?php echo $product_id; ?>" method="POST">
                <input type="text" name="flag" placeholder="Introduce la flag aquí">
                <button type="submit">Enviar Flag</button>
            </form>

            <!-- Mostrar el mensaje después de la verificación -->
            <?php if ($mensaje): ?>
                <p><?php echo $mensaje; ?></p>
            <?php endif; ?>
        </div>
    </main>
    <script src="../js/main.js"></script>
</body>
</html>
