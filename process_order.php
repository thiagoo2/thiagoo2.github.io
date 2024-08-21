<?php
// Configuración de la base de datos
$servername = "localhost";
$username = "root";
$password = "";  // Asegúrate de que esta contraseña sea correcta
$dbname = "sport_shop";
$port = 3307;  // Puerto actualizado

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Verificar conexión
if ($conn->connect_error) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'error' => 'Conexión fallida: ' . $conn->connect_error]);
    exit();
}

// Obtener datos del POST
$data = json_decode(file_get_contents('php://input'), true);

// Verificar si la decodificación JSON tuvo éxito
if (json_last_error() !== JSON_ERROR_NONE) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'error' => 'Datos JSON inválidos']);
    exit();
}

// Asignar variables
$cardNumber = $data['cardNumber'];
$expiryDate = $data['expiryDate'];
$cvv = $data['cvv'];
$clientName = $data['clientName'];
$clientEmail = $data['clientEmail'];
$clientAddress = $data['clientAddress'];
$cartItems = $data['cartItems'];
$total = $data['total'];

// Comenzar una transacción
$conn->begin_transaction();

try {
    // Insertar en la tabla de compras
    $stmt = $conn->prepare("INSERT INTO compras (nombre_cliente, email_cliente, direccion_cliente, telefono_cliente, total, numero_tarjeta, fecha_vencimiento, cvv) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $clientName, $clientEmail, $clientAddress, $telefono_cliente, $total, $cardNumber, $expiryDate, $cvv);
    
    // Datos de ejemplo, reemplaza con los datos reales si están disponibles
    $telefono_cliente = '123456789';
    $stmt->execute();
    
    $compraId = $stmt->insert_id;
    
    // Insertar en la tabla de detalles de compras
    $stmt = $conn->prepare("INSERT INTO detalle_compras (compra_id, nombre_producto, precio, cantidad) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isdi", $compraId, $nombre_producto, $precio, $cantidad);
    
    foreach ($cartItems as $item) {
        $nombre_producto = $item['name'];
        $precio = $item['price'];
        $cantidad = $item['quantity'];
        $stmt->execute();
    }
    
    // Confirmar la transacción
    $conn->commit();
    header('Content-Type: application/json');
    echo json_encode(['success' => true]);

} catch (Exception $e) {
    // Deshacer la transacción en caso de error
    $conn->rollback();
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}

// Cerrar la conexión a la base de datos
$conn->close();
?>
