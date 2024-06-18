<?php
// Incluir el archivo de conexión a la base de datos
require_once '../../php/conexion.php';
session_start();

// Verificar si el usuario ya ha iniciado sesión
if (isset($_SESSION['usuario'])) {
    header('Location: products.php'); // Redirigir al usuario a la página principal
    exit;
}

// Procesamiento de inicio de sesión y registro
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Procesar inicio de sesión
    if (isset($_POST['submit_login'])) {
        $correo_login = $_POST['correo_login'];
        $password_login = $_POST['password_login'];

        // Consultar en la base de datos para verificar las credenciales
        $sql = "SELECT * FROM usuarios WHERE correo = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $correo_login);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            // Comparar la contraseña ingresada con la contraseña almacenada
            if ($password_login === $row['password']) {
                // Iniciar sesión
                session_start();
                $_SESSION['usuario'] = $row['correo'];
                $_SESSION['nombre'] = $row['nombre']; // Puedes almacenar otros datos de sesión si lo necesitas
                header('Location: products.php'); // Redireccionar al usuario a la página principal
                exit;
            } else {
                echo '<p>Contraseña incorrecta.</p>';
            }
        } else {
            echo '<p>Usuario no encontrado.</p>';
        }

        $stmt->close();
    }

    // Procesar registro
    elseif (isset($_POST['submit_registro'])) {
        $nombre_registro = $_POST['nombre_registro'];
        $apellido_registro = $_POST['apellido_registro'];
        $correo_registro = $_POST['correo_registro'];
        $telefono_registro = $_POST['telefono_registro'];
        $password_registro = $_POST['password_registro'];

        // Insertar nuevo usuario en la base de datos
        $sql = "INSERT INTO usuarios (nombre, apellido, correo, telefono, password) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $nombre_registro, $apellido_registro, $correo_registro, $telefono_registro, $password_registro);

        if ($stmt->execute()) {
            echo '<p>Registro exitoso.</p>';
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $stmt->close();
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión o Registrarse</title>
</head>
<body>
    <h2>Iniciar Sesión</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <label for="correo_login">Correo:</label><br>
        <input type="email" id="correo_login" name="correo_login" required><br>
        <label for="password_login">Contraseña:</label><br>
        <input type="password" id="password_login" name="password_login" required><br><br>
        <input type="submit" name="submit_login" value="Iniciar Sesión">
    </form>

    <h2>Registro</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <label for="nombre_registro">Nombre:</label><br>
        <input type="text" id="nombre_registro" name="nombre_registro" required><br>
        <label for="apellido_registro">Apellido:</label><br>
        <input type="text" id="apellido_registro" name="apellido_registro" required><br>
        <label for="correo_registro">Correo electrónico:</label><br>
        <input type="email" id="correo_registro" name="correo_registro" required><br>
        <label for="telefono_registro">Teléfono:</label><br>
        <input type="tel" id="telefono_registro" name="telefono_registro" required><br>
        <label for="password_registro">Contraseña:</label><br>
        <input type="password" id="password_registro" name="password_registro" required><br><br>
        <input type="submit" name="submit_registro" value="Registrarse">
    </form>

    <script>
        function cargarFormulario(ruta) {
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "../../admin/php/" + ruta, true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {

                    document.querySelector(".ds-panel").innerHTML = xhr.responseText;
                }
            };
            xhr.send();
        }
    </script>
</body>
</html>

