<?php
include 'config.php'; // Asegúrate de que config.php contiene la conexión a la base de datos

// Datos del nuevo usuario
$usuario = 'exampleUser'; // Cambia esto por el nombre de usuario que desees
$contrasena = 'examplePassword'; // Cambia esto por la contraseña que desees

// Hashear la contraseña
$hashed_password = password_hash($contrasena, PASSWORD_DEFAULT);

// Insertar el nuevo usuario en la base de datos
$sql = "INSERT INTO usuarios (username, password) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ss', $usuario, $hashed_password);

if ($stmt->execute()) {
    echo "Usuario agregado exitosamente.";
} else {
    echo "Error al agregar el usuario: " . htmlspecialchars($stmt->error);
}

$stmt->close();
$conn->close();
?>
