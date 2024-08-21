<?php
$servername = "localhost";
$username = "root";
$password = ""; // Contraseña vacía si no usas contraseña
$dbname = "sport_shop"; // Nombre de tu base de datos
$port = 3307; // Asegúrate de que el puerto sea correcto

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

echo "Conexión exitosa";

// Cerrar conexión
$conn->close();
?>
