<?php
session_start();
require_once 'includes/funciones.php';

$errores = [];

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $categoria = $_POST['categoria'];

    if(empty($id) || empty($nombre) || empty($descripcion) || empty($precio) || empty($stock) || empty($categoria)){
        $errores[] = "Todos los campos son obligatorios."; 
    }

    

    if (!preg_match('/^\d+(\.\d{1,2})?$/', $precio) || floatval($precio) <= 0) {
    $errores[] = "Precio inválido. Usa formato como 10.50";
    }

    if(!is_numeric($stock) || $stock < 0){
        $errores[] = "Stock inválido.";
    }

    //para validar un ID reppetido
    foreach(obtenerProductos() as $prod){
        if($prod['id'] == $id){
            $errores[] = "ID ya existe. Por favor, elige otro.";
            break;
        }
    }

    //guardarlo si no hay errores
    if(empty($errores)){
        $producto = [
            'id' => $id,
            'nombre' => $nombre,
            'descripcion' => $descripcion,
            'precio' => $precio,
            'stock' => $stock,
            'categoria' => $categoria
        ];
        agregarProducto($producto);
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
            <h2 class="text-center mb-4">Agregar Producto</h2>

            <form method="POST" action="agregar.php">

                <div class="mb-3">
                    <label class="form-label">ID</label>
                    <input type="text" name="id" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="nombre" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Descripción</label>
                    <input type="text" name="descripcion" class="form-control">
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Precio</label>
                        <input type="number" step="0.01" name="precio" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Stock</label>
                        <input type="number" name="stock" class="form-control">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Categoría</label>
                    <input type="text" name="categoria" class="form-control">
                </div>

                <button class="btn btn-dark w-100" type="submit">Guardar</button>
                <br>
                <div class="text-center mt-3">
                    <a href="index.php" class="btn btn-outline-secondary btn-sm">
                        Ir a la lista
                    </a>
                </div>

            </form>
            <br>

            <?php if (!empty($errores)): ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php foreach ($errores as $e): ?>
                            <li><?= $e ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
        </div>

    </div>
</div>
</div>

<?php include("includes/footer.php"); ?>