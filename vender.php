<?php

session_start();
require_once 'includes/funciones.php';

if (isset($_GET['id'])) {
    $campos['id'] = $_GET['id'];
}

$errores  = [];
$venta_ok = '';
$campos   = ['id' => '', 'cantidad' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $vid      = trim($_POST['venta_id']       ?? '');
    $cantidad = trim($_POST['venta_cantidad'] ?? '');

    $campos = ['id' => $vid, 'cantidad' => $cantidad];

    if ($vid === '')
        $errores['id'] = 'Debes seleccionar un producto.';
    if ($cantidad === '')
        $errores['cantidad'] = 'La cantidad es obligatoria.';
    elseif (!is_numeric($cantidad))
        $errores['cantidad'] = 'La cantidad debe ser un número.';
    elseif ((int)$cantidad <= 0)
        $errores['cantidad'] = 'La cantidad debe ser mayor a cero.';

    if (empty($errores)) {
        $prod = obtenerProductoPorId($vid);
        if (!$prod) {
            $errores['id'] = 'Producto no encontrado.';
        } elseif ((int)$cantidad > (int)$prod['stock']) {
            $errores['cantidad'] = "Stock insuficiente. Disponible: {$prod['stock']} unidades.";
        } else {
            realizarVenta($vid, (int)$cantidad);
            $venta_ok = "Venta realizada: {$cantidad} unidad(es) de \"{$prod['nombre']}\".";
            $campos   = ['id' => '', 'cantidad' => ''];
        }
    }
}

$productos = obtenerProductos();
?>

<?php include("includes/header.php"); ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8 col-sm-12">

            <div class="card shadow-lg p-4">
                <h2 class="text-center mb-4">Registrar Venta</h2>

                <?php if ($venta_ok): ?>
                    <div class="alert alert-success text-center">
                        <?= htmlspecialchars($venta_ok) ?>
                    </div>
                <?php endif; ?>

                <?php if (empty($productos)): ?>
                    <div class="alert alert-warning text-center">
                        No hay productos disponibles para vender.
                    </div>
                <?php else: ?>

                <form method="POST" action="vender.php">

                    <div class="mb-3">
                        <label class="form-label">Producto</label>
                        <select name="venta_id" class="form-select">
                            <option value="">-- Selecciona un producto --</option>
                            <?php foreach ($productos as $p): ?>
                                <option value="<?= htmlspecialchars($p['id']) ?>"
                                    <?= $campos['id'] == $p['id'] ? 'selected' : '' ?>
                                    <?= (int)$p['stock'] === 0 ? 'disabled' : '' ?>>
                                    #<?= htmlspecialchars($p['id']) ?> - 
                                    <?= htmlspecialchars($p['nombre']) ?> 
                                    (Stock: <?= htmlspecialchars($p['stock']) ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if (isset($errores['id'])): ?>
                            <div class="text-danger small mt-1">
                                <?= $errores['id'] ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Cantidad</label>
                        <input type="number" 
                               name="venta_cantidad" 
                               min="1"
                               class="form-control"
                               value="<?= htmlspecialchars($campos['cantidad']) ?>">
                        <?php if (isset($errores['cantidad'])): ?>
                            <div class="text-danger small mt-1">
                                <?= $errores['cantidad'] ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-success">
                            Confirmar Venta
                        </button>
                    </div>

                </form>

                <?php endif; ?>

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
