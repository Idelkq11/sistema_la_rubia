<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit;
}

include("includes/db.php");

// Recibir datos del formulario
$fecha = $_POST['fecha'];
$codigo = $_POST['codigo_cliente'];
$nombre = $_POST['nombre_cliente'];
$comentario = $_POST['comentario'];

$articulos = $_POST['articulo'];
$cantidades = $_POST['cantidad'];
$precios = $_POST['precio'];

// Calcular total general
$total = 0;
for ($i = 0; $i < count($articulos); $i++) {
    $total += $cantidades[$i] * $precios[$i];
}

// Obtener número de recibo
$res = $conn->query("SELECT COUNT(*) as total FROM facturas");
$fila = $res->fetch_assoc();
$num = str_pad($fila['total'] + 1, 3, "0", STR_PAD_LEFT);
$recibo = "REC-" . $num;

// Insertar factura
$stmt = $conn->prepare("INSERT INTO facturas (fecha, numero_recibo, codigo_cliente, nombre_cliente, total, comentario) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssds", $fecha, $recibo, $codigo, $nombre, $total, $comentario);
$stmt->execute();
$factura_id = $stmt->insert_id;

// Insertar los artículos
$stmt2 = $conn->prepare("INSERT INTO detalle_factura (factura_id, articulo, cantidad, precio, total) VALUES (?, ?, ?, ?, ?)");
for ($i = 0; $i < count($articulos); $i++) {
    $art = $articulos[$i];
    $cant = $cantidades[$i];
    $prec = $precios[$i];
    $sub = $cant * $prec;

    $stmt2->bind_param("isidd", $factura_id, $art, $cant, $prec, $sub);
    $stmt2->execute();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Factura Guardada</title>
    <style>
        body {
            background-color: #f0f4f8;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .mensaje-box {
            background-color: #ffffff;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            max-width: 500px;
            text-align: center;
        }
        h2 {
            color: #2e7d32;
            margin-bottom: 20px;
        }
        p {
            font-size: 18px;
            margin: 10px 0;
            color: #333;
        }
        strong {
            color: #004e92;
        }
        .links {
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
    <div class="mensaje-box">
        <h2>✅ Factura guardada correctamente</h2>
        <p><strong>Número de Recibo:</strong> <?php echo $recibo; ?></p>
        <p><strong>Total:</strong> RD$<?php echo number_format($total, 2); ?></p>

        <div class="links">
            <a href="home.php">+ Registrar otra factura</a> |
            <a href="ver_reporte.php">📊 Ver reporte diario</a>
        </div>
    </div>
</body>
</html>

