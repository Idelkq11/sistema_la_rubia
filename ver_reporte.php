<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit;
}

include("includes/db.php");

$hoy = date("Y-m-d");

// Obtener total de facturas y total cobrado del día
$sql = "SELECT COUNT(*) as total_facturas, SUM(total) as total_dinero FROM facturas WHERE fecha = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $hoy);
$stmt->execute();
$resultado = $stmt->get_result()->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte Diario</title>
    <style>
        body {
            background-color: #f0f4f8;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
        }
        .reporte-container {
            background-color: #fff;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            max-width: 500px;
            width: 100%;
        }
        h2 {
            color: #004e92;
            text-align: center;
            margin-bottom: 25px;
        }
        p {
            font-size: 17px;
            margin: 10px 0;
            color: #333;
        }
        strong {
            color: #0d47a1;
        }
        .links {
            text-align: center;
            margin-top: 25px;
        }
        .links a {
            text-decoration: none;
            color: #2196f3;
            font-weight: 600;
            margin: 0 10px;
            transition: color 0.3s ease;
        }
        .links a:hover {
            color: #0d47a1;
        }
    </style>
</head>
<body>
    <div class="reporte-container">
        <h2>📊 Reporte del día: <?php echo $hoy; ?></h2>

        <p><strong>Total de facturas emitidas:</strong> <?php echo $resultado['total_facturas'] ?? 0; ?></p>
        <p><strong>Total cobrado:</strong> RD$<?php echo number_format($resultado['total_dinero'] ?? 0, 2); ?></p>

        <div class="links">
            <a href="home.php">← Volver al registro</a> |
            <a href="logout.php">🔓 Cerrar sesión</a>
        </div>
    </div>
</body>
</html>

