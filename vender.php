<?php
include 'includes/funciones.php';

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
            $errores['cantidad'] = "Stock insuficiente. Disponible: {$prod['stock']} uds.";
        } else {
            realizarVenta($vid, (int)$cantidad);
            $venta_ok = "Venta realizada: {$cantidad} unidad(es) de \"{$prod['nombre']}\".";
            $campos   = ['id' => '', 'cantidad' => ''];
        }
    }
}

$productos = obtenerProductos();
?>

<h2>Registrar Venta</h2>

<?php if ($venta_ok): ?>
    <p style="color:green;"><?= htmlspecialchars($venta_ok) ?></p>
<?php endif; ?>

<?php if (empty($productos)): ?>
    <p>No hay productos disponibles para vender.</p>
<?php else: ?>
<form method="POST" action="vender.php">

    Producto:
    <select name="venta_id">
        <option value="">-- Selecciona un producto --</option>
        <?php foreach ($productos as $p): ?>
            <option value="<?= htmlspecialchars($p['id']) ?>"
                <?= $campos['id'] == $p['id'] ? 'selected' : '' ?>
                <?= (int)$p['stock'] === 0 ? 'disabled' : '' ?>>
                #<?= htmlspecialchars($p['id']) ?> - <?= htmlspecialchars($p['nombre']) ?> (Stock: <?= htmlspecialchars($p['stock']) ?>)
            </option>
        <?php endforeach; ?>
    </select>
    <?php if (isset($errores['id'])): ?>
        <span style="color:red;"><?= $errores['id'] ?></span>
    <?php endif; ?>
    <br><br>

    Cantidad:
    <input type="number" name="venta_cantidad" min="1"
           value="<?= htmlspecialchars($campos['cantidad']) ?>">
    <?php if (isset($errores['cantidad'])): ?>
        <span style="color:red;"><?= $errores['cantidad'] ?></span>
    <?php endif; ?>
    <br><br>

    <button type="submit">Confirmar Venta</button>
</form>
<?php endif; ?>

<p><a href="index.php">Volver a la lista</a></p>
