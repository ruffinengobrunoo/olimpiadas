<?php
include 'db.php';  // Incluir archivo de conexión a la base de datos

// Función para obtener los productos
function getProducts($conn) {
    $result = $conn->query("SELECT id_articulo, nombre, precio, descripcion, stock, imagen FROM articulos");
    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
    return $products;
}

// Manejar la solicitud POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['finalizar_compra']) && $_POST['finalizar_compra'] === 'true') {
        // Procesar la finalización de la compra
        $carrito = json_decode($_POST['carrito'], true); // Obtener el carrito del FormData

        // Validar si el carrito no está vacío
        if (empty($carrito)) {
            echo json_encode(['status' => 'error', 'message' => 'El carrito está vacío.']);
            exit;
        }

        // Calcular el total
        $total = 0;
        foreach ($carrito as $producto) {
            $total += $producto['precio'] * $producto['cantidad'];
        }

        // Insertar la orden en la tabla de ordenes
        $stmt = $conn->prepare("INSERT INTO ordenes (total) VALUES (?)");
        $stmt->bind_param("d", $total);
        $stmt->execute();
        $id_orden = $stmt->insert_id; // Obtener el ID de la orden recién creada

        // Insertar los detalles de la orden en la tabla de detalles_orden
        foreach ($carrito as $producto) {
            $id_articulo = $producto['id']; // Asegúrate de que el ID del artículo es correcto
            $cantidad = $producto['cantidad'];
            $precio = $producto['precio'];

            // Insertar detalles de la orden
            $stmt = $conn->prepare("INSERT INTO detalles_orden (id_orden, id_articulo, cantidad, precio) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("iiid", $id_orden, $id_articulo, $cantidad, $precio);
            $stmt->execute();

            // Actualizar el stock en la tabla articulos
            $stmt = $conn->prepare("UPDATE articulos SET stock = stock - ? WHERE id_articulo = ?");
            $stmt->bind_param("ii", $cantidad, $id_articulo);
            $stmt->execute();
        }

        echo json_encode(['status' => 'success', 'message' => 'Compra finalizada con éxito.']);
        exit;
    } elseif (isset($_POST['id_articulo']) && isset($_POST['cantidad'])) {
        // Procesar la adición de productos al carrito
        $id_articulo = $_POST['id_articulo'];
        $cantidad = $_POST['cantidad'];

        // Consultar el stock disponible en la base de datos
        $query = $conn->prepare("SELECT stock FROM articulos WHERE id_articulo = ?");
        $query->bind_param('i', $id_articulo);
        $query->execute();
        $result = $query->get_result();

        if ($result->num_rows > 0) {
            $producto = $result->fetch_assoc();
            $stock_disponible = $producto['stock'];

            if ($cantidad > $stock_disponible) {
                echo json_encode(['status' => 'error', 'message' => 'No hay suficiente stock disponible.']);
            } else {
                echo json_encode(['status' => 'success', 'message' => 'Producto agregado al carrito.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Producto no encontrado.']);
        }
        exit;
    }
}

// Obtener los productos si la solicitud no es POST
$products = getProducts($conn);

// Verificar si los productos están disponibles y enviarlos como JSON si se requiere
if (!empty($products)) {
    echo json_encode($products);
} else {
    echo json_encode(['status' => 'error', 'message' => 'No se encontraron productos.']);
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Productos</title>
    <link rel="stylesheet" href="../css/productos.css"> <!-- Incluye aquí tu archivo CSS -->
    <link rel="icon" href="DeportesBLIT/img/logo/favicon.jpg" type="image/x-icon">
   
</head>
<body>

<style>
   #carrito, #abrirCarrito {
    filter: invert(100%);
    width: 45px;
    height: auto;
    position: absolute;
    top: 14px;
    cursor: pointer;
        }
#cart {
    position: fixed;
    right: 0;
    top: 0;
    width: 300px;
    height: 100%;
    background: #fff;
    border-left: 2px solid #ddd;
    box-shadow: -2px 0 5px rgba(0,0,0,0.1);
    overflow-y: auto;
    padding: 20px;
    color: black;
}

.cart-container {
    display: none; /* Asegúrate de que esté oculto inicialmente */
    color: black;
}

.cart-open {
    display: block; /* Muestra el carrito cuando se abre */

}

.close-cart {
    cursor: pointer;
    font-size: 20px;
    float: right;
    color: black;
}

.item-carrito {
    border-bottom: 1px solid #ddd;
    padding: 10px 0;
    color: black;
}

.total-container {
    font-size: 18px;
    font-weight: bold;
    padding-top: 20px;
    color: black;
}

</style>

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
    <img id="abrirCarrito" src="../img/carrito-de-compras.png" alt="Carrito" width="40">
    </div>
    <div id="cart" class="cart-container">
    <span class="close-cart" onclick="cerrarCarrito()">✖</span>
    <h3>Tu Carrito</h3>
    <div id="productosCompra"></div>
    <div id="total" class="total-container">Total: $0.00</div>
    <!-- Botón para finalizar compra -->
    <button id="finalizarCompra" onclick="finalizarCompra()">Finalizar Compra</button>
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
<section class="product-section">
    <?php if (!empty($products)): ?>
        <?php foreach ($products as $product): ?>
        <div class="catalog-item articulof">
            <img src="<?= $product['imagen']; ?>" alt="<?= $product['nombre']; ?>" class="catalog-img">
            <h3><?= $product['nombre']; ?></h3>
            <p><?= $product['descripcion']; ?></p>
            <p>Precio: $<?= number_format($product['precio'], 2); ?></p>
            <p>Stock disponible: <?= $product['stock']; ?></p>
            <button onclick="addToCart(<?= $product['id_articulo']; ?>, '<?= $product['nombre']; ?>', <?= $product['precio']; ?>, <?= $product['stock']; ?>)">Agregar al carrito</button>

   </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No hay productos disponibles.</p>
    <?php endif; ?>
</section>

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
    <script src="../js/filtro.js"></script>
    <script src="../js/cart.js" defer></script>
</footer>
</body>
</html>