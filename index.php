<?php
require 'php/config.php';

// Comprobamos si Existe el Archivo con los Usuarios para La Administracion, si no lo creamos
if (file_exists(realpath("admin/php/usuarios.json"))) {
	//Comprobamos si la Carpeta del Tema Existe, si no Mostramos Error
	if (file_exists("themes/$tema_select")) {
		require "themes/$tema_select/index.php";
	} else {
		echo 'La Carpeta <strong>'.$tema_select.'</strong> no ha sido Encontrada.
		<p>Configura la Ruta en la <a href="admin/"><strong>Administracion</strong></a></p>';
	}
} else {
	require_once 'php/crearUsuarios.php';
}
?>