<?php
session_start();
require_once 'includes/funciones.php';

$errores = [];

// =============================
// VALIDAR QUE VENGA EL ID
// =============================
if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit();
}

$id_original = $_GET['id'];
$producto    = obtenerProductoPorId($id_original);

if (!$producto) {
    header('Location: index.php');
    exit();
}


// =============================
// PROCESAR FORMULARIO
// =============================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = $_POST['id'];
    $nombre = trim($_POST['nombre']);
    $descripcion = trim($_POST['descripcion']);
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $categoria = trim($_POST['categoria']);

    
    if (empty($nombre) || empty($descripcion) || empty($precio) || empty($stock) || empty($categoria)) {
        $errores[] = "Todos los campos son obligatorios.";
    }

 
    if (!preg_match('/^\d+(\.\d{1,2})?$/', $precio) || floatval($precio) <= 0) {
        $errores[] = "Precio inválido. Usa formato como 10.50";
    }


    if (!is_numeric($stock) || $stock < 0) {
        $errores[] = "Stock inválido.";
    }

    
    if (empty($errores)) {

        $nuevo_producto = [
            'id' => $id,
            'nombre' => $nombre,
            'descripcion' => $descripcion,
            'precio' => $precio,
            'stock' => $stock,
            'categoria' => $categoria
        ];

        editarProducto($id_original, $nuevo_producto);

        $_SESSION['mensaje'] = "Producto actualizado correctamente";

        header("Location: index.php");
        exit();
    }
}
?>

<?php include("includes/header.php"); ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8 col-sm-12">

            <div class="card shadow-lg p-4">
                <h2 class="text-center mb-4">Editar Producto</h2>
                <form method="POST" action="editar.php?id=<?= $producto['id'] ?>">

                    <div class="mb-3">
                        <label class="form-label">ID</label>
                        <input type="text" name="id" class="form-control"
                               value="<?= htmlspecialchars($producto['id']) ?>" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" name="nombre" class="form-control"
                               value="<?= htmlspecialchars($producto['nombre']) ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Descripción</label>
                        <input type="text" name="descripcion" class="form-control"
                               value="<?= htmlspecialchars($producto['descripcion']) ?>">
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Precio</label>
                            <input type="number" step="0.01" name="precio" class="form-control"
                                   value="<?= htmlspecialchars($producto['precio']) ?>">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Stock</label>
                            <input type="number" name="stock" class="form-control"
                                   value="<?= htmlspecialchars($producto['stock']) ?>">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Categoría</label>
                        <input type="text" name="categoria" class="form-control"
                               value="<?= htmlspecialchars($producto['categoria']) ?>">
                    </div>

                        <!-- Mostrar errores -->
                    <?php if (!empty($errores)): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php foreach ($errores as $e): ?>
                                    <li><?= $e ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-dark">
                            Guardar Cambios
                        </button>
                    </div>

                </form>

                <div class="text-center mt-3">
                    <a href="index.php" class="btn btn-outline-secondary btn-sm">
                        Volver a la lista
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include("includes/footer.php"); ?>