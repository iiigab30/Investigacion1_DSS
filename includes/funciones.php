<?php
session_start(); //función de ubicación y persistencia

//arreglo de productos
if(!isset($_SESSION['productos'])){
    $_SESSION['productos'] = [];
}

//funcion para obtener los productos
function obtenerProductos(){
    return $_SESSION['productos'];
}
// Obtener un producto por ID
function obtenerProductoPorId($id) {
    foreach ($_SESSION['productos'] as $p) {
        if ($p['id'] == $id) return $p;
    }
    return null;
}

//funcion para guardar un producto
function agregarProducto($producto){
    $_SESSION['productos'][] = $producto;
}

// Editar un producto existente
function editarProducto($id_original, $producto) {
    foreach ($_SESSION['productos'] as $i => $p) {
        if ($p['id'] == $id_original) {
            $_SESSION['productos'][$i] = $producto;
            break;
        }
    }
}
//eliminar un producto
function eliminarProducto($id){
    foreach($_SESSION['productos'] as $index => $prod){
        if($prod['id'] == $id){
            unset($_SESSION['productos'][$index]);
        }
    }
    $_SESSION['productos'] = array_values($_SESSION['productos'])
}

// Realizar una venta (descontar stock)
function realizarVenta($id, $cantidad) {
    foreach ($_SESSION['productos'] as $i => $p) {
        if ($p['id'] == $id) {
            $_SESSION['productos'][$i]['stock'] -= $cantidad;
            break;
        }
    }
}

// Verificar si un ID ya existe
function idExiste($id, $excluir = null) {
    foreach ($_SESSION['productos'] as $p) {
        if ($p['id'] == $id && $p['id'] != $excluir) return true;
    }
    return false;
}




