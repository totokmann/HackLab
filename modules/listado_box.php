<?php
$query = "SELECT labs_id, nombre_lab, dificultad FROM labs INNER JOIN tipo ON labs.tipo_id = tipo.tipo_id";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();
?>
<div class="container">
    <main class="main-content">
        <h1>Listado de productos</h1>
        <div class="machines">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="machine">
                    <h3><?php echo $row['nombre_lab']; ?></h3>
                    <p>Dificultad:<?php echo $row['dificultad']; ?></p>
                    <a href="./product/product.php?id=<?php echo $row['labs_id']; ?>">Ver detalles</a>
                </div>
            <?php endwhile; ?>
        </div>
    </main>
</div>
<script src="../js/main.js"></script>
