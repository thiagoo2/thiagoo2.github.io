<?php
session_start();

// Inicializa la variable de carrito
$cartItems = isset($_POST['cart_items']) ? json_decode($_POST['cart_items'], true) : [];

// Inicializa variables de error
$errors = [
    'card_number' => '',
    'expiry_date' => '',
    'cvv' => '',
    'client_name' => '',
    'client_email' => '',
    'client_address' => ''
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cardNumber = $_POST['card_number'] ?? '';
    $expiryDate = $_POST['expiry_date'] ?? '';
    $cvv = $_POST['cvv'] ?? '';
    $clientName = $_POST['client_name'] ?? '';
    $clientEmail = $_POST['client_email'] ?? '';
    $clientAddress = $_POST['client_address'] ?? '';

    $hasErrors = false;

    // Validar campos
    if (!isValidCardNumber($cardNumber)) {
        $errors['card_number'] = 'Número de tarjeta inválido.';
        $hasErrors = true;
    }
    if (!isValidExpiryDate($expiryDate)) {
        $errors['expiry_date'] = 'Fecha de expiración inválida.';
        $hasErrors = true;
    }
    if (!isValidCVV($cvv)) {
        $errors['cvv'] = 'CVV inválido.';
        $hasErrors = true;
    }
    if (empty($clientName)) {
        $errors['client_name'] = 'Nombre y apellido son obligatorios.';
        $hasErrors = true;
    }
    if (!isValidEmail($clientEmail)) {
        $errors['client_email'] = 'Email inválido.';
        $hasErrors = true;
    }
    if (empty($clientAddress)) {
        $errors['client_address'] = 'Dirección es obligatoria.';
        $hasErrors = true;
    }

    if ($hasErrors) {
        // Mostrar errores en el formulario
    } else {
        // Guardar datos en la base de datos
        $mysqli = new mysqli('localhost', 'root', '', 'sport_shop');
        if ($mysqli->connect_error) {
            die('Error de conexión (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
        }

        $stmt = $mysqli->prepare('INSERT INTO orders (client_name, client_email, client_address) VALUES (?, ?, ?)');
        $stmt->bind_param('sss', $clientName, $clientEmail, $clientAddress);
        $stmt->execute();
        $orderId = $stmt->insert_id;

        $stmt = $mysqli->prepare('INSERT INTO order_items (order_id, product_name, quantity, price) VALUES (?, ?, ?, ?)');
        foreach ($cartItems as $item) {
            $stmt->bind_param('isid', $orderId, $item['name'], $item['quantity'], $item['price']);
            $stmt->execute();
        }
        $stmt->close();
        $mysqli->close();

        // Vaciar el carrito
        unset($_SESSION['cart']);
        header("Location: confirmacion.php"); // Cambia a tu página de confirmación
        exit();
    }
}

function isValidCardNumber($number) {
    return preg_match('/^\d{16}$/', $number);
}

function isValidExpiryDate($date) {
    return preg_match('/^\d{2}\/\d{2}$/', $date);
}

function isValidCVV($cvv) {
    return preg_match('/^\d{3}$/', $cvv);
}

function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}
?>
