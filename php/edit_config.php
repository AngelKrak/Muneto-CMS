<?php
include 'config.php';
$config = fopen("config.php", 'w+') or die("Error al Editar la Configuracion");

//Condiciones para la Configuracion del Sitio, Si se presiona el Boton de Editar titulo de la web, solo se edita ese y el Slogan se quedara como estaba
if ($_REQUEST['editar_titulo_web'] || $_REQUEST['editar_config']) {
	$titulo_web = $_REQUEST['titulo_web'];
} else {
	$titulo_web;
}

if ($_REQUEST['editar_slogan'] || $_REQUEST['editar_config']) {
	$slogan = $_REQUEST['slogan'];
} else {
	$slogan;
}

fwrite($config, '<?php
	$titulo_web = "'.$titulo_web.'";
	$slogan = "'.$slogan.'";
	$tema_select = "'.$tema_select.'";
	$version = "'.$version.'";
?>');

//Redireccionamos a la Configuracion
header('Location: ../admin/#configuracion');
?>