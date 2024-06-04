<?php
require '../../admin/php/conexion.php';

$error = "";
$validacion_exitosa = true;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = limpiar_datos($_POST["usuario"]);
    $password = limpiar_datos($_POST["password"]);

    if (empty($usuario) || empty($password)) {
        $error = "Por favor, completa todos los campos.";
        $validacion_exitosa = false;
    } else {
        // Consultar la base de datos para verificar las credenciales
        $sql = "SELECT password FROM admins WHERE nombre = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            if ($password == $row['password']) {
                session_start();
                header("Location: ./admin.php");
                exit;
            } else {
                // Contraseña incorrecta
                $error = "Contraseña incorrecta. Por favor, inténtalo de nuevo.";
                $validacion_exitosa = false;
            }
        } else {
            // Usuario no encontrado
            $error = "El usuario ingresado no existe.";
            $validacion_exitosa = false;
        }
    }
}

function limpiar_datos($dato) {
    $dato = trim($dato);
    $dato = stripslashes($dato);
    $dato = htmlspecialchars($dato);
    return $dato;
}
?>


<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Iniciar Sesión</title>
  <link rel="stylesheet" href="../../scss/login/login.css">
</head>

<body>
  <section>
    <div class="difuminador"></div>
    <div class="contenedor">
      <div class="formulario">
        <form method="POST">
          <h2>Iniciar Sesión</h2>
          <div class="input-container">
            <i class="fa-solid fa-user"></i>
            <input type="text" name="usuario" required>
            <label for="#">Usuario</label>
          </div>
          <div class="input-container">
            <i class="fa-solid fa-lock"></i>
            <input type="password" name="password" required>
            <label for="#">Contraseña</label>
          </div>
          <div class="button">
            <button type="submit" name="submit">Acceder</button>
          </div>
          <?php if (!$validacion_exitosa && !empty($error)) : ?>
            <p class="error"><?php echo $error; ?></p>
          <?php endif; ?>
        </form>
      </div>
    </div>
  </section>

  <!-- Script for FontAwesome -->
  <script src="https://kit.fontawesome.com/75a5f6846b.js" crossorigin="anonymous"></script>
</body>

</html>
