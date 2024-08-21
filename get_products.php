<?php
// Configuración de la base de datos
$servername = "localhost"; // O la IP si el servidor no está en localhost
$username = "root"; // Cambiar si usas un nombre de usuario diferente
$password = ""; // Cambiar si tienes una contraseña establecida
$dbname = "sport_shop";
$port = 3307; // Cambiar al puerto que esté configurado en XAMPP

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener el parámetro de categoría del filtro (si existe)
$category = isset($_GET['category']) ? $_GET['category'] : 'all';

// Consultar los productos de la base de datos
if ($category === 'all') {
    $sql = "SELECT id, nombre, precio, categoria, imagen FROM productos";
    $result = $conn->query($sql);
} else {
    $sql = "SELECT id, nombre, precio, categoria, imagen FROM productos WHERE categoria = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $category);
    $stmt->execute();
    $result = $stmt->get_result();
}

// Asegurarse de usar el resultado correcto
$productos = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $productos[] = $row;
    }
} else {
    $productos = [];
}

// Devolver los productos como JSON
header('Content-Type: application/json');
echo json_encode($productos);

// Cerrar la conexión a la base de datos
$conn->close();
?>
