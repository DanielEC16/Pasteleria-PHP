<?php
session_start();
// Destruir todas las variables de sesión
$_SESSION = array();
// Destruir la sesión
session_destroy();
// Redireccionar a la página de inicio
header("location: ../../pages/products/products.php");
exit;
?>
