<?php
$categoria = $_REQUEST['categoriaEliminar'];

$Categorias = "categorias.php";
$abrir = file_get_contents($Categorias);
$reemplazamos = str_replace(array(');', "\"$categoria\", "), '', $abrir);
$agregamos = $reemplazamos.');';
file_put_contents($Categorias, $agregamos);

require_once 'categorias.php';
if(in_array($categoria, $categorias)) {
	echo "<div id='success' class='alert alert-danger' role='alert'>¡¡Error!! La Categoria no ha sido Eliminada</div>";
} else {
	echo "<div id='success' class='alert alert-success' role='alert'>La Categoria se Elimino Correctamente</div>";
}
?>