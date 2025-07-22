<?php
$conexion = new mysqli("localhost", "root", "", "");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Crear base de datos
$conexion->query("CREATE DATABASE IF NOT EXISTS ventas_rubia");
$conexion->select_db("ventas_rubia");

// Tabla usuarios
$conexion->query("CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50) NOT NULL,
    clave VARCHAR(255) NOT NULL
)");

// Usuario demo
$clave = password_hash("tareafacil25", PASSWORD_DEFAULT);
$conexion->query("INSERT INTO usuarios (usuario, clave) VALUES ('demo', '$clave')");

// Tabla facturas
$conexion->query("CREATE TABLE IF NOT EXISTS facturas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fecha DATE,
    numero_recibo VARCHAR(20),
    codigo_cliente VARCHAR(20),
    nombre_cliente VARCHAR(100),
    total DECIMAL(10,2),
    comentario TEXT
)");

// Tabla detalle_factura
$conexion->query("CREATE TABLE IF NOT EXISTS detalle_factura (
    id INT AUTO_INCREMENT PRIMARY KEY,
    factura_id INT,
    articulo VARCHAR(100),
    cantidad INT,
    precio DECIMAL(10,2),
    total DECIMAL(10,2),
    FOREIGN KEY (factura_id) REFERENCES facturas(id)
)");

echo "✅ Instalación completada correctamente. Ya puedes ir al login.";
?>
