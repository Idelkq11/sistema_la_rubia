<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Registrar Factura</title>
    <style>
        body {
            background-color: #f0f4f8;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
        }
        form {
            max-width: 700px;
            background-color: #ffffff;
            padding: 30px 40px;
            margin: auto;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        h2, h3 {
            color: #004e92;
            text-align: center;
            margin-bottom: 20px;
        }
        label {
            display: block;
            font-weight: 600;
            color: #555;
            margin-top: 10px;
        }
        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 10px 12px;
            border: 1.5px solid #b0bec5;
            border-radius: 5px;
            font-size: 14px;
            margin-top: 5px;
            margin-bottom: 15px;
        }
        input[type="text"]:focus, input[type="number"]:focus {
            border-color: #2196f3;
            outline: none;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            margin-bottom: 20px;
        }
        th {
            background-color: #e3f2fd;
            color: #0d47a1;
            padding: 10px;
            text-align: left;
            font-weight: 600;
        }
        td {
            padding: 10px;
        }
        table, th, td {
            border: 1.5px solid #b0bec5;
        }
        table input[type="text"], table input[type="number"] {
            width: 100%;
            box-sizing: border-box;
        }
        .btn-agregar {
            background-color: #2196f3;
            color: #fff;
            padding: 10px 18px;
            border: none;
            border-radius: 5px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .btn-agregar:hover {
            background-color: #1976d2;
        }
        input[type="submit"] {
            background-color: #2196f3;
            color: #fff;
            border: none;
            padding: 12px;
            font-weight: 600;
            border-radius: 5px;
            width: 100%;
            font-size: 16px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #1976d2;
        }
        .links {
            text-align: center;
            margin-top: 20px;
        }
        .links a {
            color: #2196f3;
            text-decoration: none;
            font-weight: 600;
            margin: 0 15px;
        }
        .links a:hover {
            color: #0d47a1;
        }
    </style>
    <script>
        function agregarFila() {
            const tabla = document.getElementById("tablaArticulos");
            const fila = tabla.insertRow(-1);
            const celdaArticulo = fila.insertCell(0);
            const celdaCantidad = fila.insertCell(1);
            const celdaPrecio = fila.insertCell(2);

            celdaArticulo.innerHTML = `<input type="text" name="articulo[]" placeholder="Nombre del artículo" required>`;
            celdaCantidad.innerHTML = `<input type="number" name="cantidad[]" min="1" value="1" required>`;
            celdaPrecio.innerHTML = `<input type="number" name="precio[]" min="0" step="0.01" value="0.00" required>`;
        }

        window.onload = function() {
            agregarFila(); // Añadir una fila al cargar
        }
    </script>
</head>
<body>

    <form action="guardar_factura.php" method="post">
        <h2>Registro de Factura</h2>

        <label>Fecha:</label>
        <input type="text" name="fecha" value="<?php echo date('Y-m-d'); ?>" readonly>

        <label>Código del Cliente:</label>
        <input type="text" name="codigo_cliente" required placeholder="Ej: CLI001">

        <label>Nombre del Cliente:</label>
        <input type="text" name="nombre_cliente" required placeholder="Nombre completo del cliente">

        <h3>Artículos</h3>
        <table id="tablaArticulos">
            <tr>
                <th style="width: 50%;">Artículo</th>
                <th style="width: 25%;">Cantidad</th>
                <th style="width: 25%;">Precio</th>
            </tr>
            <!-- Las filas se agregarán con JS -->
        </table>
        <button type="button" class="btn-agregar" onclick="agregarFila()">+ Agregar Artículo</button>

        <label>Comentario:</label>
        <input type="text" name="comentario" placeholder="Comentarios opcionales">

        <input type="submit" value="Guardar e Imprimir">
    </form>

    <div class="links">
        <a href="ver_reporte.php">📊 Ver Reporte Diario</a> |
        <a href="logout.php">🔓 Cerrar sesión</a>
    </div>

</body>
</html>
