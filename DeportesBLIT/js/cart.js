// cart.js


// Arreglo para almacenar los productos del carrito
let carrito = [];

// Función para abrir y cerrar el carrito
document.addEventListener('DOMContentLoaded', () => {
    const abrirCarritoBtn = document.getElementById('abrirCarrito');
    if (abrirCarritoBtn) {
        abrirCarritoBtn.addEventListener('click', () => {
            document.getElementById('cart').classList.toggle('cart-open');
        });
    }
});

// Función para cerrar el carrito
function cerrarCarrito() {
    document.getElementById('cart').classList.remove('cart-open');
}

// Función para agregar productos al carrito y verificar el stock
function addToCart(id, nombre, precio, stock) {
    console.log(`Añadiendo al carrito: id=${id}, nombre=${nombre}, precio=${precio}, stock=${stock}`);
    const productoExistente = carrito.find(item => item.id === id);
    const cantidad = productoExistente ? productoExistente.cantidad + 1 : 1;

    fetch('../php/verPRODUCTOS.php', { // Aquí debes poner la ruta correcta si es necesario
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `id_articulo=${id}&cantidad=${cantidad}`
    })
    .then(response => response.json())
    .then(data => {
        console.log('Respuesta del servidor:', data);
        if (data.status === 'success') {
            if (productoExistente) {
                productoExistente.cantidad++;
            } else {
                carrito.push({ id, nombre, precio, cantidad, stock });
            }
            renderCarrito();
        } else {
            alert(data.message);
        }
    })
    .catch(error => console.error('Error:', error));
}
// Función para renderizar el carrito en el DOM
function renderCarrito() {
    const productosCompra = document.getElementById("productosCompra");
    const total = document.getElementById("total");
    productosCompra.innerHTML = "";
    let totalCarrito = 0;

    carrito.forEach(producto => {
        const item = document.createElement("div");
        item.className = "item-carrito";
        item.innerHTML = `
            <p>${producto.nombre}</p>
            <p>Cantidad: 
                <button onclick="cambiarCantidad(${producto.id}, 'restar')">-</button>
                ${producto.cantidad}
                <button onclick="cambiarCantidad(${producto.id}, 'sumar')">+</button>
            </p>
            <p>Precio: $${producto.precio}</p>
            <button onclick="eliminarProducto(${producto.id})">Eliminar</button>
        `;
        productosCompra.appendChild(item);
        totalCarrito += producto.precio * producto.cantidad;
    });

    total.innerHTML = `Total: $${totalCarrito.toFixed(2)}`;
}

// Función para cambiar la cantidad de productos en el carrito
function cambiarCantidad(id, accion) {
    const producto = carrito.find(item => item.id === id);
    
    if (accion === "sumar" && producto.cantidad < producto.stock) {
        producto.cantidad++;
    } else if (accion === "restar" && producto.cantidad > 1) {
        producto.cantidad--;
    }
    
    renderCarrito();
}

// Función para eliminar un producto del carrito
function eliminarProducto(id) {
    carrito = carrito.filter(item => item.id !== id);
    renderCarrito();
}


/**/ 
function finalizarCompra() {
    const formData = new FormData();
    formData.append('finalizar_compra', 'true'); // Enviar un formulario en vez de JSON
    formData.append('carrito', JSON.stringify(carrito)); // Convertir a JSON

    fetch('../php/verPRODUCTOS.php', {
        method: 'POST',
        body: formData // Usar FormData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            alert('¡Compra finalizada con éxito!');
            limpiarCarrito(); // Limpiar y actualizar
        } else {
            alert('Hubo un problema al finalizar la compra: ' + data.message);
        }
    })
    .catch(error => console.error('Error:', error));
}
