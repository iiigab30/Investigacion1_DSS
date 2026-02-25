<?php
include "includes/funciones.php";

if(isset($_GET['id'])){
    eliminarProducto($_GET['id']);
}

header("Location: index.php");

?>