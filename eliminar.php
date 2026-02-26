<?php
// Inicia la sesión para poder acceder a los datos almacenados (productos)
session_start();

// Incluye el archivo donde están todas las funciones del sistema (CRUD)
require_once "includes/funciones.php";

// Verifica si se recibió un ID por la URL (GET)
// Ejemplo: eliminar.php?id=3
if(isset($_GET['id'])){
    
    // Llama a la función eliminarProducto()
    eliminarProducto($_GET['id']);
}

// Redirige automáticamente al usuario a la página principal (index.php)
header("Location: index.php");
?>