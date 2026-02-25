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

//funcion para guardar un producto
function agregarProducto($producto){
    $_SESSION['productos'][] = $producto;
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
