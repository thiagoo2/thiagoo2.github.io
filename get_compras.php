<?php
header('Content-Type: application/json');

// Conectar a la base de datos
$host = 'localhost'; // O la IP del servidor de base de datos
$dbname = 'sport_shop'; // Nombre de tu base de datos
$user = 'root'; // Tu usuario de base de datos
$pass = ''; // Tu contraseña de base de datos

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Consulta para obtener las compras
    $stmt = $pdo->prepare("SELECT * FROM compras"); // Asegúrate de que 'compras' es el nombre correcto de tu tabla
    $stmt->execute();

    $compras = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($compras);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
