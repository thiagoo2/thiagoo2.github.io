<?php
session_start(); // Asegúrate de que la sesión esté iniciada

include 'config.php'; // Incluye el archivo de configuración para la conexión a la base de datos

// Verifica el método de solicitud
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "Método de solicitud no válido. Se esperaba POST, pero se recibió " . $_SERVER['REQUEST_METHOD'];
    exit;
}
include 'config.php'; // Asegúrate de que la ruta al archivo config.php sea correcta


// Verifica que los datos del formulario están presentes
if (isset($_POST['nombre_usuario']) && isset($_POST['contrasena'])) {
    $nombre_usuario = $_POST['nombre_usuario'];
    $contrasena = $_POST['contrasena'];

    // Preparar la consulta SQL para evitar inyecciones SQL
    $sql = "SELECT contrasena FROM usuarios WHERE nombre_usuario = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die('Error en la preparación de la consulta: ' . htmlspecialchars($conn->error));
    }

    $stmt->bind_param('s', $nombre_usuario); // 's' indica que el parámetro es una cadena
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Verificar la contraseña usando password_verify
        if (password_verify($contrasena, $row['contrasena'])) {
            $_SESSION['nombre_usuario'] = $nombre_usuario; // Guardar el nombre de usuario en la sesión
            header('Location: productos.php'); // Redirigir a la página principal
            exit();
        } else {
            echo "Usuario o contraseña incorrectos";
        }
    } else {
        echo "Usuario no encontrado";
    }

    $stmt->close();
} else {
    echo "Datos del formulario no encontrados.";
}

$conn->close();
?>
