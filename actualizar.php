<?php
include 'includes/funciones.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit();
}

$id_original = trim($_POST['id_original'] ?? '');
$id          = trim($_POST['id']          ?? '');
$nombre      = trim($_POST['nombre']      ?? '');
$descripcion = trim($_POST['descripcion'] ?? '');
$precio      = trim($_POST['precio']      ?? '');
$stock       = trim($_POST['stock']       ?? '');
$categoria   = trim($_POST['categoria']   ?? '');

$errores = [];

// Campos vacíos
if ($id === '')          $errores[] = 'El ID es obligatorio.';
if ($nombre === '')      $errores[] = 'El nombre es obligatorio.';
if ($descripcion === '') $errores[] = 'La descripción es obligatoria.';
if ($precio === '')      $errores[] = 'El precio es obligatorio.';
if ($stock === '')       $errores[] = 'El stock es obligatorio.';
if ($categoria === '')   $errores[] = 'La categoría es obligatoria.';

// Numéricos
if ($id !== ''     && !is_numeric($id))      $errores[] = 'El ID debe ser un número.';
if ($precio !== '' && !is_numeric($precio))  $errores[] = 'El precio debe ser un número.';
if ($stock !== ''  && !is_numeric($stock))   $errores[] = 'El stock debe ser un número.';

// Negativos
if (is_numeric($id)     && (int)$id <= 0)      $errores[] = 'El ID debe ser mayor a cero.';
if (is_numeric($precio) && (float)$precio < 0) $errores[] = 'El precio no puede ser negativo.';
if (is_numeric($stock)  && (int)$stock < 0)    $errores[] = 'El stock no puede ser negativo.';

// ID duplicado (excepto el mismo producto)
if (is_numeric($id) && (int)$id > 0 && idExiste($id, $id_original))
    $errores[] = 'El ID ya existe en otro producto.';

if (!empty($errores)) {
    foreach ($errores as $e) echo "<p style='color:red'>$e</p>";
    echo '<form action="actualizar.php" method="POST">';
    echo '<input type="hidden" name="id_original" value="' . htmlspecialchars($id_original) . '">';
    echo 'ID: <input type="text" name="id" value="' . htmlspecialchars($id) . '"><br>';
    echo 'Nombre: <input type="text" name="nombre" value="' . htmlspecialchars($nombre) . '"><br>';
    echo 'Descripción: <input type="text" name="descripcion" value="' . htmlspecialchars($descripcion) . '"><br>';
    echo 'Precio: <input type="number" step="any" name="precio" value="' . htmlspecialchars($precio) . '"><br>';
    echo 'Stock: <input type="number" name="stock" value="' . htmlspecialchars($stock) . '"><br>';
    echo 'Categoría: <input type="text" name="categoria" value="' . htmlspecialchars($categoria) . '"><br>';
    echo '<button type="submit">Actualizar</button></form>';
    echo '<p><a href="index.php">Volver a la lista</a></p>';
    exit();
}

editarProducto($id_original, compact('id', 'nombre', 'descripcion', 'precio', 'stock', 'categoria'));
header('Location: index.php');
exit();
