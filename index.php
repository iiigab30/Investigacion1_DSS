<?php
include 'includes/funciones.php';
$productos = obtenerProductos();
?>

<h2>Lista de Productos</h2>
<a href="agregar.php">Agregar producto</a>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Descripción</th>
        <th>Precio</th>
        <th>Stock</th>
        <th>Acciones</th>
    </tr>

    <?php foreach($productos as $p): ?>
    <tr>
        <td><?= $p['id']; ?></td>
        <td><?= $p['nombre']; ?></td>
        <td><?= $p['descripcion']; ?></td>
        <td><?= $p['precio']; ?></td>
        <td><?= $p['stock']; ?></td>
        <td>
            <a href="editar.php?id=<?= $p['id']; ?>">Editar</a>
            <a href="eliminar.php?id=<?= $p['id']; ?>" onclick="return confirm('¿Deseas eliminar este producto?');">Eliminar</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table> 