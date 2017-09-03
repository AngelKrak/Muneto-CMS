<?php
function securePost($variable) {
  $securePost = htmlentities($variable, ENT_QUOTES, 'utf-8');
  return $securePost;
}

if (isset($_POST['categoriaNueva']) || $_POST['categoriaNueva'] != '') {
	$categoria = securePost($_POST['categoriaNueva']);

	$Categorias = "categorias.json";
	$abrir = file_get_contents($Categorias);
	$reemplazamos = str_replace(');', '', $abrir);
	$agregamos = $reemplazamos.'"'.$categoria.'", );';
	file_put_contents($Categorias, $agregamos);
}
?>