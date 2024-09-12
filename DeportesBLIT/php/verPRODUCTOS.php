<?php
// Conexión a la base de datos
include 'db.php'; // Asegúrate de tener este archivo configurado para la conexión a la base de datos

// Función para obtener los productos
function getProducts($conn) {
    $result = $conn->query("SELECT nombre, precio, descripcion, imagen FROM articulos");
    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
    return $products;
}

$products = getProducts($conn); // Obtener productos para mostrar
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Productos</title>
    <link rel="stylesheet" href="../css/productos.css"> <!-- Incluye aquí tu archivo CSS -->
    <link rel="icon" href="DeportesBLIT/img/logo/favicon.jpg" type="image/x-icon">
    <style>
        /* Estilo del modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            width: 400px;
            text-align: center;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .bank-logo {
            width: 60px;
            height: 60px;
            margin: 10px;
        }

        .modal input, .modal select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .modal button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .modal button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<header id="header">
    <div class="deportesblit">
        <a href="../../index.html">
            <img src="../img/logo/logoHEADER.jpeg" alt="Logo">
        </a>
    </div>

    <div class="nav">
        <ul>
            <li><a href="../../index.html">Inicio</a></li>
            <li><a href="Nosotros.html">Nosotros</a></li>
            <li><a href="metodospago.html">Métodos de pago</a></li>
        </ul>
    </div>

    <div class="search-cart">
        <input type="text" id="buscador" placeholder="Buscar...">
        <a href="#" class="search-icon">🔍</a>
        <a href="../php/loginusuario.php" class="">👤</a>

        <div>
            <img id="carrito" class="carrito" src="../img/carrito-de-compras.png" alt="Carrito">
            <div id="numero"></div>
        </div>
    </div>
</header>

<section class="category-section">
        <h2>TUS PRODUCTOS FAVORITOS EN TU LUGAR FAVORITO</h2>
        <br>
        <h2>MAS COMPRADOS</h2>
    </section>
    <section class="product-section">
        <div class="product">
            <img src="../img/deporteshombres/ropafutbol.png" alt="Futbol" class="product-img">
            <h3>FUTBOL</h3>
    
        </div>
        <div class="product">
            <img src="../img/deporteshombres/ropacasual.png" alt="Lifestyle" class="product-img">
            <h3>LIFESTYLE</h3>
            
        </div>
        <!-- Nuevas imágenes -->
        <div class="product">
            <img src="../img/deporteshombres/ropabasquet.jpg" alt="Basketball" class="product-img">
            <h3>BASQUET</h3>
            <div class="product-buttons"> 
            </div>
        </div>
    </section>
    
    <!-- Sección de equipos -->
    <section class="team-selection">
        <h2>ENCONTRÁ A TU EQUIPO</h2>
        <div class="team-logos">
            <img src="../img/equipos/river.png" alt="River Plate" class="team-logo">
            <img src="../img/equipos/boca.png" alt="Boca Juniors" class="team-logo">
            <img src="../img/equipos/juventus.png" alt="Juventus" class="team-logo">
            <img src="../img/equipos/bayern.png" alt="Bayern Munich" class="team-logo">
            <img src="../img/equipos/realmadrid.png" alt="Real Madrid" class="team-logo">
            <img src="../img/equipos/united.png" alt="Manchester United" class="team-logo">
            <img src="../img/equipos/arsenal.png" alt="Arsenal" class="team-logo">
        </div>
    </section>
    
    <!-- Sección de imágenes con título y descripción -->
    <section class="catalog-preview">
        <div class="catalog-item">
            <img src="../img/noticiashombre/running.jpg" alt="Running" class="catalog-img">
            <h3>Buenos Aires 21K</h3>
            <p>Prepará tus zapatillas para la próxima carrera.</p>
        </div>
        <div class="catalog-item">
            <img src="../img/noticiashombre/zapasdobles.jpg" alt="Adidas Shoes" class="catalog-img">
            <h3>Adidas Originals</h3>
            <p>Un clásico que nunca pasa de moda.</p>
        </div>
        <div class="catalog-item">
            <img src="../img/noticiashombre/messif50.jpg" alt="Messi" class="catalog-img">
            <h3>Lionel Messi</h3>
            <p>La leyenda sigue en la cancha.</p>
        </div>
        <div class="catalog-item">
            <img src="../img/noticiashombre/sanlo.jpg" alt="Messi" class="catalog-img">
            <h3>San Lorenzo</h3>
            <p>La leyenda sigue en la cancha.</p>
        </div>

    </section>

<!-- Sección de imágenes con título y descripción -->
<section class="catalog-preview">
 
    <?php if (!empty($products)): ?>
        <?php foreach ($products as $product): ?>
        <div class="catalog-item articulof" >
            <img src="<?= $product['imagen']; ?>" alt="<?= $product['nombre']; ?>" class="catalog-img">
            <h3><?= $product['nombre']; ?></h3>
            <p><?= $product['descripcion']; ?></p>
            <p>Precio: $<?= number_format($product['precio'], 2); ?></p>
        </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No hay productos disponibles.</p>
    <?php endif; ?>
</section>

    <!-- CARRITO

<div class="products"> 
    <main>
        <div id="contenedor" class="contenedor"></div>
    </main>

    <div id="contenedorCompra">
        <div class="informacionCompra" id="informacionCompra">
            <h2>Cesta</h2>
            <p class="x" id="x">x</p>
        </div>

        <div class="productosCompra" id="productosCompra"></div>
        <div class="total" id="total"></div>
        <button id="openModalBtn">Efectuar Compra</button>

        <div id="myModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>

                <div>
                    <img src="../img/metodospago/paypal.png" alt="Banco 1" class="bank-logo">
                    <img src="../img/metodospago/visa.png" alt="Banco 2" class="bank-logo">
                    <img src="../img/metodospago/mastercard.png" alt="Banco 3" class="bank-logo">
                </div>

                <form id="purchaseForm">
                    <input type="text" id="buyerName" name="buyerName" placeholder="Nombre del comprador" required>
                    <input type="text" id="accountNumber" name="accountNumber" placeholder="Número de tarjeta" required>
                    <select id="bankName" name="bankName" required>
                        <option value="" disabled selected>Seleccione su banco</option>
                        <option value="paypal">Paypal</option>
                        <option value="visa">Visa</option>
                        <option value="mastercard">Mastercard</option>
                    </select>

                    <div class="input-group">
                        <input type="text" id="expiryDate" name="expiryDate" placeholder="Fecha de vencimiento (MM/AA)" required>
                        <input type="text" id="cvv" name="cvv" placeholder="CVV" required>
                    </div>

                    <button type="submit">Confirmar Compra</button>
                </form>
            </div>
        </div>
    </div>
</div>
    -->

<script>
    const modal = document.getElementById("myModal");
    const btn = document.getElementById("openModalBtn");
    const span = document.getElementsByClassName("close")[0];
    const form = document.getElementById("purchaseForm");

    btn.onclick = function() {
        modal.style.display = "flex";
    }

    span.onclick = function() {
        modal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    form.onsubmit = function(event) {
        event.preventDefault();
        const buyerName = document.getElementById("buyerName").value;
        const accountNumber = document.getElementById("accountNumber").value;
        const bankName = document.getElementById("bankName").value;
        const expiryDate = document.getElementById("expiryDate").value;
        const cvv = document.getElementById("cvv").value;

        alert(`Compra confirmada:\nNombre: ${buyerName}\nCuenta: ${accountNumber}\nBanco: ${bankName}\nFecha de Vencimiento: ${expiryDate}\nCVV: ${cvv}`);
        modal.style.display = "none";
    }
</script>


<section class="team-selection">
        <h2>ENCONTRÁ A TU EQUIPO</h2>
        <div class="team-logos">
            <img src="../img/descubremujeres/mina1.png" alt="mina1" class="team-logo">
            <img src="../img/descubremujeres/mina2.png" alt="mina2" class="team-logo">
            <img src="../img/descubremujeres/mina3.png" alt="mina3" class="team-logo">
            <img src="../img/descubremujeres/mina4.png" alt="mina4" class="team-logo">
            <img src="../img/descubremujeres/mina5.png" alt="mina5" class="team-logo">
        </div>
    </section>
    
    <!-- Sección de imágenes con título y descripción -->
    <section class="catalog-preview">
        <div class="catalog-item">
            <img src="../img/noticiasmujer/f50negra.png" alt="Running" class="catalog-img">
            <h3>F50 x Real Madrid</h3>
            <p>Por el club mas grande de todos los tiempos</p>
        </div>
        <div class="catalog-item">
            <img src="../img/noticiasmujer/21kMujer.png" alt="Adidas Shoes" class="catalog-img">
            <h3>21k Por Buenos Aires</h3>
            <p>Conquista la media maraton con una seleccion de calzado especial .</p>
        </div>
        <div class="catalog-item">
            <img src="../img/noticiasmujer/ZapasViper.png" alt="Messi" class="catalog-img">
            <h3>VP Viper 76</h3>
            <p>Un clasico de culto con un complemento venenoso.</p>
        </div>
        <div class="catalog-item">
            <img src="../img/noticiasmujer/china.jpeg" alt="Messi" class="catalog-img">
            <h3>Descubri Adicolor</h3>
            <p>Una busqueda por todos los iconicos colores</p>
        </div>
    </section>


<footer>
    <div class="footer-container">
        <div class="footer-column">
            <h3>Sobre Nosotros</h3>
            <p>DeportesBLIT es tu tienda deportiva de confianza, ofreciendo la mejor selección de productos para cada disciplina. Nuestra misión es inspirar y equipar a los atletas de todos los niveles.</p>
        </div>
        <div class="footer-column">
            <h3>Enlaces Rápidos</h3>
            <ul>
                <li><a href="../../index.html">Inicio</a></li>
                <li><a href="productos.html">Tienda</a></li>
                <li><a href="nosotros.html">Contacto</a></li>
            </ul>
        </div>
        <div class="footer-column">
            <h3>Contacto</h3>
            <p><strong>Dirección:</strong> Avenida Siempre Viva 742, Springfield</p>
            <p><strong>Teléfono:</strong> +123 456 789</p>
            <p><strong>Email:</strong> contacto@deportesblit.com</p>
        </div>
        <div class="footer-column">
            <h3>Redes Sociales</h3>
            <div class="social-icons">
                <a href="#"><img src="../img/redes/facebook.png" alt="Facebook"></a>
                <a href="#"><img src="../img/redes/instagram.png" alt="Instagram"></a>
                <a href="#"><img src="../img/redes/twitter.png" alt="Twitter"></a>
            </div>
        </div>
    </div>
    <script src="filtro.js"></script>
</footer>
</body>
</html>