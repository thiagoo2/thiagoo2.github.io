<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compras - Sport Shop</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Compras Realizadas</h1>
        <nav>
            <ul>
                <li><a href="index.html">Inicio</a></li>
                <li><a href="productos.html">Productos</a></li>
                <li><a href="compras.html">Compras</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h2>Lista de Compras</h2>
        <div id="compras-list"></div>
    </main>

    <footer>
        <p>© 2024 Sport Shop. Todos los derechos reservados.</p>
    </footer>

    <script>
        function loadCompras() {
            fetch('get_compras.php')
                .then(response => response.json())
                .then(compras => {
                    const comprasList = document.getElementById('compras-list');
                    comprasList.innerHTML = '';

                    if (compras.length > 0) {
                        compras.forEach(compra => {
                            const compraDiv = document.createElement('div');
                            compraDiv.classList.add('compra-item');
                            compraDiv.innerHTML = `
                                <p><strong>Usuario:</strong> ${compra.usuario}</p>
                                <p><strong>Producto:</strong> ${compra.producto}</p>
                                <p><strong>Cantidad:</strong> ${compra.cantidad}</p>
                                <p><strong>Fecha:</strong> ${compra.fecha_compra}</p>
                            `;
                            comprasList.appendChild(compraDiv);
                        });
                    } else {
                        comprasList.innerHTML = '<p>No hay compras registradas.</p>';
                    }
                })
                .catch(error => {
                    console.error('Error al cargar compras:', error);
                });
        }

        // Cargar compras al cargar la página
        document.addEventListener('DOMContentLoaded', loadCompras);
    </script>
</body>
</html>
