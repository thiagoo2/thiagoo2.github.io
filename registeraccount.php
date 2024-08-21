<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['nombre_usuario']) && isset($_POST['contrasena'])) {
        $nombre_usuario = $_POST['nombre_usuario'];
        $contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO usuarios (nombre_usuario, contrasena) VALUES (?, ?)");
        if ($stmt === false) {
            die('Error en la preparación de la consulta: ' . htmlspecialchars($conn->error));
        }

        $stmt->bind_param('ss', $nombre_usuario, $contrasena);

        if ($stmt->execute()) {
            // Redirigir al usuario a la página principal después del registro
            header("Location: index.html");
            exit(); // Asegúrate de que el script termine después de la redirección
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Datos del formulario no encontrados.";
    }
} else {
    echo "Método de solicitud no válido.";
}

$conn->close();
?>
