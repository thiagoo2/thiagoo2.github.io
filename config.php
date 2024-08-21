<?php
$servername = "localhost";
$username = "root";
$password = ""; // La contraseña por defecto para root en XAMPP suele estar vacía
$dbname = "sport_shop";
$port = 3307; // Puerto actualizado

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
