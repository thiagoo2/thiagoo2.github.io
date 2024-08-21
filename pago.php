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
    'client_address' => '',
    'client_phone' => ''
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cardNumber = $_POST['card_number'] ?? '';
    $expiryDate = $_POST['expiry_date'] ?? '';
    $cvv = $_POST['cvv'] ?? '';
    $clientName = $_POST['client_name'] ?? '';
    $clientEmail = $_POST['client_email'] ?? '';
    $clientAddress = $_POST['client_address'] ?? '';
    $clientPhone = $_POST['client_phone'] ?? '';
    $totalAmount = array_sum(array_column($cartItems, 'price'));

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
    if (empty($clientPhone)) {
        $errors['client_phone'] = 'Teléfono es obligatorio.';
        $hasErrors = true;
    }

    if ($hasErrors) {
        // Mostrar errores en el formulario
    } else {
        // Guardar datos en la base de datos
        $host = 'localhost';
        $user = 'root';
        $password = ''; // Asegúrate de que esté vacío si no usas contraseña
        $database = 'sport_shop';

        $conn = new mysqli("localhost", "root", "", "sport_shop", "3307");

        // Verificar la conexión
        if ($mysqli->connect_error) {
            die('Error de conexión (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
        }

        // Preparar e insertar datos en la tabla `compra`
        $stmt = $mysqli->prepare('INSERT INTO compra (nombre_cliente, email_cliente, direccion_cliente, telefono_cliente, total, numero_tarjeta, fecha_vencimiento, cvv, fecha_compra) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())');
        $stmt->bind_param('ssssisss', $clientName, $clientEmail, $clientAddress, $clientPhone, $totalAmount, $cardNumber, $expiryDate, $cvv);
        $stmt->execute();
        $orderId = $stmt->insert_id;

        $stmt->close();
        $mysqli->close();

        // Vaciar el carrito
        unset($_SESSION['cart']);
        header("Location: productos.php"); // Redirige a la página de productos después del pago
        exit();
    }
}

// Funciones de validación
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

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagar</title>
    <link rel="stylesheet" href="styles.css"> <!-- Incluye tu CSS aquí -->
    <style>
        .error-input {
            border: 1px solid red;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <header>
        <h1>Formulario de Pago</h1>
    </header>
    <main>
        <section>
            <h2>Detalles del Pedido</h2>
            <ul>
                <?php foreach ($cartItems as $item): ?>
                    <li>
                        <?php echo htmlspecialchars($item['name']); ?> - <?php echo htmlspecialchars($item['quantity']); ?> x <?php echo htmlspecialchars($item['price']); ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </section>

        <section>
            <h2>Información de Pago</h2>
            <form action="pago.php" method="post">
                <input type="hidden" name="cart_items" value="<?php echo htmlspecialchars(json_encode($cartItems)); ?>">

                <label for="card_number">Número de Tarjeta:</label>
                <input type="text" id="card_number" name="card_number" class="<?php echo $errors['card_number'] ? 'error-input' : ''; ?>" value="<?php echo htmlspecialchars($cardNumber ?? ''); ?>">
                <div class="error"><?php echo $errors['card_number']; ?></div>

                <label for="expiry_date">Fecha de Expiración:</label>
                <input type="text" id="expiry_date" name="expiry_date" class="<?php echo $errors['expiry_date'] ? 'error-input' : ''; ?>" value="<?php echo htmlspecialchars($expiryDate ?? ''); ?>">
                <div class="error"><?php echo $errors['expiry_date']; ?></div>

                <label for="cvv">CVV:</label>
                <input type="text" id="cvv" name="cvv" class="<?php echo $errors['cvv'] ? 'error-input' : ''; ?>" value="<?php echo htmlspecialchars($cvv ?? ''); ?>">
                <div class="error"><?php echo $errors['cvv']; ?></div>

                <label for="client_name">Nombre y Apellido:</label>
                <input type="text" id="client_name" name="client_name" class="<?php echo $errors['client_name'] ? 'error-input' : ''; ?>" value="<?php echo htmlspecialchars($clientName ?? ''); ?>">
                <div class="error"><?php echo $errors['client_name']; ?></div>

                <label for="client_email">Email:</label>
                <input type="email" id="client_email" name="client_email" class="<?php echo $errors['client_email'] ? 'error-input' : ''; ?>" value="<?php echo htmlspecialchars($clientEmail ?? ''); ?>">
                <div class="error"><?php echo $errors['client_email']; ?></div>

                <label for="client_address">Dirección:</label>
                <input type="text" id="client_address" name="client_address" class="<?php echo $errors['client_address'] ? 'error-input' : ''; ?>" value="<?php echo htmlspecialchars($clientAddress ?? ''); ?>">
                <div class="error"><?php echo $errors['client_address']; ?></div>

                <label for="client_phone">Teléfono:</label>
                <input type="text" id="client_phone" name="client_phone" value="<?php echo htmlspecialchars($clientPhone ?? ''); ?>">

                <button type="submit">Pagar</button>
            </form>
        </section>
    </main>
</body>
</html>
