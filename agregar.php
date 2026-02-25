<?php
include 'includes/funciones.php';

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
    if(!is_numeric($precio) || $precio <= 0){
        $errores[] = "Precio inválido. Debe ser un número positivo.";
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

<h2>Agregar Producto:</h2>
<?php
foreach($errores as $error)
    echo "<p style='color:red'>$error</p>";
?>

<form method="POST" action="agregar.php">
    ID: <input type="text" name="id"><br>
    Nombre: <input type="text" name="nombre"><br>
    Descripción: <input type="text" name="descripcion"><br>
    Precio: <input type="number" name="precio"><br>
    Stock: <input type="number" name="stock"><br>
    Categoría: <input type="text" name="categoria"><br>

    <button type="submit">Guardar Producto</button>
</form>
