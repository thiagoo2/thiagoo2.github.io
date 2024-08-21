<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos - Sport Shop</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&display=swap">
</head>
<body>
    <header>
        <h1>Sport Shop</h1>
        <nav>
            <ul>
                <li><a href="index.html">Inicio</a></li>
                <li><a href="productos.php">Productos</a></li>
                <li><a href="#">Contacto</a></li>
            </ul>
        </nav>
        <div id="user">
            <?php
            session_start();
            if (isset($_SESSION['nombre_usuario'])) {
                echo "<p>Bienvenido, " . $_SESSION['nombre_usuario'] . " | <a href='logout.php'>Cerrar sesión</a></p>";
            } else {
                echo '<a href="login.html">Iniciar sesión</a> | <a href="register.html">Registrarse</a>';
            }
            ?>
        </div>
        <div id="cart">
            <a href="#" onclick="toggleCart()">Carrito (0)</a>
        </div>
    </header>

    <main>
        <div id="filter">
            <label for="sport-filter">Filtrar por deporte:</label>
            <select id="sport-filter" onchange="filterProducts()">
                <option value="all">Todos los productos</option>
                <option value="futbol">Fútbol</option>
                <option value="tenis">Tenis</option>
                <option value="natacion">Natación</option>
                <option value="boxeo">Boxeo</option>
                <option value="baloncesto">Baloncesto</option>
                <option value="softball">Softball</option>
            </select>
        </div>

        <div id="productos">
            <!-- Los productos se cargarán aquí usando JavaScript -->
        </div>

        <div id="cart-dropdown" style="display: none;">
            <h2>Carrito de Compras</h2>
            <div id="cart-items"></div>
            <button onclick="clearCart()">Vaciar Carrito</button>
            <!-- Botón Comprar -->
            <form id="buy-form" action="pago.php" method="post">
             <input type="hidden" name="cart_items" id="cart-items-hidden">
             <button type="submit">Comprar</button>
            </form>

            <div id="error-messages" class="error-messages"></div> <!-- Contenedor para mensajes de error -->
        </div>
    </main>

    <footer>
        <p>© 2024 Sport Shop. Todos los derechos reservados.</p>
    </footer>

    <script src="script.js"></script>
    <script>
        // Cargar productos en la página de productos
        loadProducts();
    </script>
</body>
</html>
