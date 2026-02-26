<?php
// Inicia la sesión para poder usar variables de sesión (como mensajes)
session_start();

// Incluye el archivo donde están las funciones (CRUD de productos)
require_once 'includes/funciones.php';

// Obtiene todos los productos (probablemente desde sesión o arreglo)
$productos = obtenerProductos();
?>

<?php 
// Incluye el encabezado (HTML, Bootstrap, menú, etc.)
include("includes/header.php"); 
?>

<div class="container mt-5">

    <!-- Título principal -->
    <h2 class="text-center mb-4">Lista de Productos</h2>

    <!-- Botón para agregar un nuevo producto -->
    <div class="d-flex justify-content-between mb-3">
        <a href="agregar.php" class="btn btn-success">+ Agregar Producto</a>
    </div>

    <!-- Tarjeta que contiene la tabla -->
    <div class="card shadow-lg p-3">

        <!-- Hace la tabla responsive (scroll en pantallas pequeñas) -->
        <div class="table-responsive">

            <!-- Mostrar mensaje de éxito (por ejemplo: producto agregado/eliminado) -->
            <?php if (isset($_SESSION['mensaje'])): ?>
                <div class="alert alert-success text-center">
                    
                    <!-- Muestra el mensaje -->
                    <?= $_SESSION['mensaje']; 
                    
                    // Elimina el mensaje para que no se repita al recargar
                    unset($_SESSION['mensaje']); 
                    ?>
                </div>
            <?php endif; ?>

            <!-- Tabla de productos -->
            <table class="table table-hover align-middle">

                <!-- Encabezado de la tabla -->
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Categoría</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <!-- Cuerpo de la tabla -->
                <tbody>

                    <!-- Recorre todos los productos -->
                    <?php foreach ($productos as $p): ?>
                    <tr>

                        <!-- Muestra cada atributo del producto -->
                        <td><?= $p['id'] ?></td>
                        <td><?= $p['nombre'] ?></td>
                        <td>$<?= $p['precio'] ?></td>
                        <td><?= $p['stock'] ?></td>
                        <td><?= $p['categoria'] ?></td>

                        <!-- Botones de acciones -->
                        <td>

                            <!-- Editar producto -->
                            <a href="editar.php?id=<?= $p['id'] ?>" 
                               class="btn btn-primary btn-sm">
                               Editar
                            </a>

                            <!-- Eliminar producto con confirmación -->
                            <a href="eliminar.php?id=<?= $p['id'] ?>" 
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('¿Deseas eliminar este producto?')">
                               Eliminar
                            </a>

                            <!-- Comprar (disminuye stock probablemente) -->
                            <a href="vender.php?id=<?= $p['id'] ?>" 
                               class="btn btn-primary btn-sm">
                               Comprar
                            </a>

                        </td>
                    </tr>

                    <?php endforeach; ?>

                </tbody>
            </table>

        </div>
    </div>
</div>

<?php 
// Incluye el footer (pie de página)
include("includes/footer.php"); 
?>