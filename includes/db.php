<?php
$conn = new mysqli("localhost", "root", "", "ventas_rubia");

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>
