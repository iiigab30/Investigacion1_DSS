<?php

// Verifica si la variable de sesión 'productos' existe.
// Si no existe, la inicializa como un arreglo vacío.
// Esto asegura que siempre tengamos un arreglo donde guardar productos.
if (!isset($_SESSION['productos'])) {
    $_SESSION['productos'] = [];
}

//obtener productos
// Devuelve todos los productos almacenados en la sesión.
function obtenerProductos() {
    return $_SESSION['productos'];
}

//guardar productos
// Recibe un arreglo de productos y lo guarda en la sesión.
// Se usa cada vez que se modifica la lista (agregar, editar, eliminar).
function guardarProductos($productos) {
    $_SESSION['productos'] = $productos;
}

//agregar producto
// Recibe un producto (como arreglo asociativo)
// Lo agrega al arreglo de productos existente.
function agregarProducto($producto) {
    $productos = obtenerProductos();   // Obtiene productos actuales
    $productos[] = $producto;         // Agrega el nuevo producto
    guardarProductos($productos);     // Guarda cambios en sesión
}


// Busca un producto específico usando su ID.
function obtenerProductoPorId($id) {
    $productos = obtenerProductos();  // Obtiene todos los productos

    // Recorre cada producto
    foreach ($productos as $producto) {

        // Si el ID coincide, devuelve ese producto
        if ($producto['id'] == $id) {
            return $producto;
        }
    }

    // Si no lo encuentra, devuelve null
    return null;
}

//venta
// Recibe el ID del producto y la cantidad a vender.
function realizarVenta($id, $cantidad) {

    $productos = obtenerProductos(); // Obtiene todos los productos

    // Recorre los productos con índice
    foreach ($productos as $index => $producto) {

        // Si encuentra el producto por ID
        if ($producto['id'] == $id) {

            // Verifica si hay suficiente stock
            if ($producto['stock'] >= $cantidad) {

                // Resta la cantidad vendida al stock
                $productos[$index]['stock'] -= $cantidad;

                // Guarda los cambios
                guardarProductos($productos);

                return true; // Venta exitosa

            } else {
                return false; // No hay suficiente stock
            }
        }
    }

    return false; // Producto no encontrado
}

//editar el producto
// Recibe el ID original y un nuevo arreglo con los datos actualizados.
function editarProducto($id, $nuevo_producto) {
    $productos = obtenerProductos(); // Obtiene productos actuales

    // Recorre los productos
    foreach ($productos as $index => $producto) {

        // Si encuentra el producto por ID
        if ($producto['id'] == $id) {

            // Reemplaza el producto antiguo por el nuevo
            $productos[$index] = $nuevo_producto;

            break; // Sale del ciclo
        }
    }

    // Guarda los cambios en la sesión
    guardarProductos($productos);
}

// Recibe el ID del producto a eliminar.
function eliminarProducto($id) {

    $productos = obtenerProductos(); // Obtiene productos actuales

    // Filtra el arreglo dejando todos los productos
    // excepto el que tenga el ID recibido.
    $productos = array_filter($productos, function($producto) use ($id) {
        return $producto['id'] != $id;
    });

    // Reorganiza los índices del arreglo (array_values)
    // y guarda los cambios en la sesión.
    guardarProductos(array_values($productos));
}