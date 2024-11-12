<?php
$query = "SELECT labs_id, nombre_lab, dificultad FROM labs INNER JOIN tipo ON labs.tipo_id = tipo.tipo_id";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HackLab - Listado de productos</title>
    <link rel="stylesheet" href="../css/inicio.css">
</head>
<body>
    <div class="container">
        <main class="main-content">
            <h1>Listado de productos</h1>
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Dificultad</th>
                        <th>Detalles</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['nombre_lab']; ?></td>
                            <td><?php echo $row['dificultad']; ?></td>
                            <td><a href="product/product.php?id=<?php echo $row['labs_id']; ?>">Ver detalles</a></td>
                        </tr>
                        <?php endwhile; ?>
                </tbody>
            </table>
        </main>
    </div>
    <script src="../js/main.js"></script>
</body>
</html>