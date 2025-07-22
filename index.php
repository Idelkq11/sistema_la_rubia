<?php
session_start();
include("includes/db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST["usuario"];
    $clave = $_POST["clave"];

    $stmt = $conn->prepare("SELECT clave FROM usuarios WHERE usuario=?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $stmt->bind_result($clave_hash);

    if ($stmt->fetch() && password_verify($clave, $clave_hash)) {
        $_SESSION["usuario"] = $usuario;
        header("Location: home.php");
        exit;
    } else {
        $error = "❌ Usuario o clave incorrectos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Login - La Rubia</title>
    <style>
        body {
            background-color: #f0f4f8;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-box {
            background: #fff;
            padding: 30px 40px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            width: 320px;
        }
        h2 {
            color: #004e92;
            text-align: center;
            margin-bottom: 25px;
            font-weight: 700;
        }
        label {
            display: block;
            margin-bottom: 6px;
            font-weight: 600;
            color: #555;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px 12px;
            margin-bottom: 20px;
            border: 1.5px solid #b0bec5;
            border-radius: 5px;
            font-size: 14px;
            transition: border-color 0.3s ease;
        }
        input[type="text"]:focus,
        input[type="password"]:focus {
            border-color: #2196f3;
            outline: none;
        }
        input[type="submit"] {
            width: 100%;
            background-color: #2196f3;
            border: none;
            padding: 12px 0;
            border-radius: 5px;
            color: white;
            font-weight: 700;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #1976d2;
        }
        .error {
            background-color: #f8d7da;
            color: #842029;
            border: 1px solid #f5c2c7;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            font-size: 14px;
            text-align: center;
        }
        .footer-text {
            text-align: center;
            color: #888;
            font-size: 13px;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>Iniciar Sesión</h2>

        <?php if (isset($error)): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="post" action="">
            <label for="usuario">Usuario:</label>
            <input type="text" id="usuario" name="usuario" required placeholder="Ingrese su usuario" />

            <label for="clave">Clave:</label>
            <input type="password" id="clave" name="clave" required placeholder="Ingrese su clave" />

            <input type="submit" value="Ingresar" />
        </form>

        <div class="footer-text">
            Usuario por defecto: <strong>demo</strong><br />
            Clave: <strong>tareafacil25</strong>
        </div>
    </div>
</body>
</html>
