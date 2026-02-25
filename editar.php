<?php
include 'includes/funciones.php';

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
?>

<h2>Editar Producto</h2>

<form action="actualizar.php" method="POST">
    <input type="hidden" name="id_original" value="<?= htmlspecialchars($id_original) ?>">

    ID: <input type="text" name="id" value="<?= htmlspecialchars($producto['id']) ?>"><br>
    Nombre: <input type="text" name="nombre" value="<?= htmlspecialchars($producto['nombre']) ?>"><br>
    Descripción: <input type="text" name="descripcion" value="<?= htmlspecialchars($producto['descripcion']) ?>"><br>
    Precio: <input type="number" step="any" name="precio" value="<?= htmlspecialchars($producto['precio']) ?>"><br>
    Stock: <input type="number" name="stock" value="<?= htmlspecialchars($producto['stock']) ?>"><br>
    Categoría: <input type="text" name="categoria" value="<?= htmlspecialchars($producto['categoria']) ?>"><br>

    <button type="submit">Actualizar</button>
</form>

<p><a href="index.php">Volver a la lista</a></p>
