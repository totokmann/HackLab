<?php
    if (isset($_POST['name'])) {
        $name = $_POST['name'];
    } else {
        $name = "";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laboratorio XSS</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Bienvenido al laboratorio de XSS</h1>
    <p>Introduce tu nombre para continuar:</p>
    
    <form action="index.php" method="POST">
        <input type="text" name="name" placeholder="Introduce tu nombre">
        <button type="submit">Enviar</button>
    </form>

    <?php if ($name): ?>
        <p>Hola, <?php echo $name; ?>!</p>
    <?php endif; ?>
</body>
</html>
