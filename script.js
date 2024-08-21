function updateCartHiddenField() {
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    const cartItemsHidden = document.getElementById('cart-items-hidden');

    // Convertir el carrito a una cadena JSON
    cartItemsHidden.value = JSON.stringify(cart);
}

document.addEventListener('DOMContentLoaded', () => {
    // Inicializar carrito y productos
    updateCart();
    updateCartHiddenField(); // Actualizar el campo oculto del carrito
    loadProducts();

    // Agregar un evento para filtrar los productos cuando cambie el filtro
    const sportFilter = document.getElementById('sport-filter');
    if (sportFilter) {
        sportFilter.addEventListener('change', filterProducts);
    }
});

function loadProducts(category = 'all') {
    fetch(`get_products.php?category=${category}`)
        .then(response => response.json())
        .then(products => {
            console.log(products); // Depuración: verifica la respuesta
            const productContainer = document.getElementById('productos');
            if (productContainer) {
                productContainer.innerHTML = ''; // Limpiar productos existentes

                if (Array.isArray(products) && products.length > 0) {
                    products.forEach(product => {
                        // Validar que el producto tenga todos los campos necesarios
                        if (product.nombre && product.precio && product.imagen && product.categoria) {
                            const productDiv = document.createElement('div');
                            productDiv.classList.add('product');
                            productDiv.dataset.category = product.categoria; // Usar "categoria"
                            productDiv.innerHTML = `
                                <img src="${product.imagen}" alt="${product.nombre}"> 
                                <h3>${product.nombre}</h3> 
                                <p>$${product.precio}</p>
                                <button onclick="addToCart('${product.nombre}', ${product.precio})">Agregar al Carrito</button>
                            `;
                            productContainer.appendChild(productDiv);
                        }
                    });
                } else {
                    productContainer.innerHTML = '<p>No hay productos disponibles.</p>';
                }
            }
        })
        .catch(error => {
            console.error('Error al cargar productos:', error);
        });
}

function filterProducts() {
    const filter = document.getElementById('sport-filter').value;
    loadProducts(filter);
}

function addToCart(name, price) {
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    const existingItem = cart.find(item => item.name === name);

    if (existingItem) {
        existingItem.quantity++;
    } else {
        cart.push({ name, price, quantity: 1 });
    }

    localStorage.setItem('cart', JSON.stringify(cart));
    updateCart();
    updateCartHiddenField(); // Actualizar el campo oculto después de agregar al carrito
}


function toggleCart() {
    const cartDropdown = document.getElementById('cart-dropdown');
    if (cartDropdown) {
        cartDropdown.style.display = cartDropdown.style.display === 'block' ? 'none' : 'block';
    }
}

function updateCart() {
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    const cartItemsDiv = document.getElementById('cart-items');
    
    cartItemsDiv.innerHTML = ''; // Limpia el contenido actual

    if (cart.length === 0) {
        cartItemsDiv.innerHTML = '<p>Tu carrito está vacío.</p>';
    } else {
        cart.forEach(item => {
            const itemDiv = document.createElement('div');
            itemDiv.innerHTML = `
                <p>${item.name} - $${item.price} x ${item.quantity}</p>
                <button onclick="removeFromCart('${item.name}')">Eliminar</button>
            `;
            cartItemsDiv.appendChild(itemDiv);
        });
    }

    // Actualiza el conteo del carrito
    const cartCount = cart.length;
    document.querySelector('#cart a').textContent = `Carrito (${cartCount})`;
}


function showLogin() {
    document.getElementById('login-form').style.display = 'block';
    document.getElementById('register-form').style.display = 'none';
}

function showRegister() {
    document.getElementById('register-form').style.display = 'block';
    document.getElementById('login-form').style.display = 'none';
}

function showPaymentForm() {
    hideAll(); // Ocultar otros elementos
    const paymentFormDiv = document.getElementById('payment-form');
    if (paymentFormDiv) {
        paymentFormDiv.style.display = 'block';
    }
}

function hideAll() {
    document.getElementById('login-form').style.display = 'none';
    document.getElementById('register-form').style.display = 'none';
    document.getElementById('cart-dropdown').style.display = 'none';
    const paymentFormDiv = document.getElementById('payment-form');
    if (paymentFormDiv) {
        paymentFormDiv.style.display = 'none';
    }
}




// Función para procesar el pago
function processPayment() {
    // Obtener los datos del formulario
    const cardNumber = document.getElementById('card-number').value;
    const expiryDate = document.getElementById('expiry-date').value;
    const cvv = document.getElementById('cvv').value;
    const clientName = document.getElementById('client-name').value;
    const clientEmail = document.getElementById('client-email').value;
    const clientAddress = document.getElementById('client-address').value;

    // Obtener los elementos del carrito
    const cartItems = getCartItems();

    // Limpiar mensajes de error previos
    const errorMessagesDiv = document.getElementById('error-messages');
    errorMessagesDiv.innerHTML = '';

    let errors = [];
    
    if (!clientEmail.includes('@')) {
        errors.push('* El correo electrónico no es válido.');
    }
    if (!/^\d{16}$/.test(cardNumber)) {
        errors.push('* El número de tarjeta debe tener 16 dígitos.');
    }
    if (!/^\d{2}\/\d{2}$/.test(expiryDate)) {
        errors.push('* La fecha de vencimiento debe estar en formato MM/AA.');
    }
    if (!/^\d{3}$/.test(cvv)) {
        errors.push('* El CVV debe tener 3 dígitos.');
    }
    if (!clientName) {
        errors.push('* El nombre del cliente es obligatorio.');
    }
    if (!clientAddress) {
        errors.push('* La dirección es obligatoria.');
    }

    // Si hay errores, mostrarlos y detener el proceso
    if (errors.length > 0) {
        errors.forEach(error => {
            const errorDiv = document.createElement('div');
            errorDiv.innerHTML = error;
            errorMessagesDiv.appendChild(errorDiv);
        });
        return;
    }

    const data = {
        cardNumber: cardNumber,
        expiryDate: expiryDate,
        cvv: cvv,
        clientName: clientName,
        clientEmail: clientEmail,
        clientAddress: clientAddress,
        cartItems: cartItems,
        total: calculateCartTotal()
    };

    // Enviar los datos al servidor
    fetch('process_order.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.text())  // Cambia a text() para ver la respuesta completa
    .then(text => {
        console.log('Response Text:', text);  // Imprime la respuesta completa
        try {
            const result = JSON.parse(text);
            if (result.success) {
                alert('Compra realizada con éxito');
                localStorage.removeItem('cart'); // Vacía el carrito después de la compra
                updateCart();
            } else {
                alert('Error al procesar la compra: ' + result.error);
            }
        } catch (e) {
            console.error('Error al parsear JSON:', e);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}


// Funciones de validación
function isValidCardNumber(number) {
    return /^\d{16}$/.test(number); // Valida un número de tarjeta de 16 dígitos
}

function isValidExpiryDate(date) {
    // Valida la fecha en formato MM/AA
    const [month, year] = date.split('/');
    return /^\d{2}\/\d{2}$/.test(date) && month >= 1 && month <= 12;
}

function isValidCVV(cvv) {
    return /^\d{3}$/.test(cvv); // Valida un CVV de 3 dígitos
}

function isValidEmail(email) {
    // Usa una expresión regular simple para validar el correo electrónico
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
}



// Función para obtener los elementos del carrito
function getCartItems() {
    // Recuperar el carrito de compras del almacenamiento local
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    return cart;
}

// Función para calcular el total del carrito
function calculateCartTotal() {
    const cartItems = getCartItems();
    return cartItems.reduce((total, item) => total + item.price * item.quantity, 0);
}


function removeFromCart(productName) {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    cart = cart.filter(item => item.name !== productName);
    localStorage.setItem('cart', JSON.stringify(cart));
    updateCart();
}

function clearCart() {
    localStorage.removeItem('cart');
    updateCart();
}
