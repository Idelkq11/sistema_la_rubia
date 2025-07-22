<?php
session_start();
session_destroy(); // elimina la sesión actual
header("Location: index.php"); // redirige al login
exit;
?>
