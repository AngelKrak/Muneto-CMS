<?php
session_start();
$G = $_SESSION['usuario'];
$Correo = $_SESSION['correo'];
$Contraseña = $_SESSION['contrasena'];
$Rango = $_SESSION['rango'];
$Imagen = $_SESSION['imagen'];
$Nombre = $_SESSION['nombre'];

if (isset($_REQUEST['editar_nombre'])) {
	$cuenta_nombre = $_REQUEST["cuenta_nombre"];
	$archivo = 'usuarios.php';
	$content = file_get_contents($archivo);
	$content = str_replace($Nombre,$cuenta_nombre,$content);
	file_put_contents($archivo,$content);
	$_SESSION['nombre'] = $cuenta_nombre;
	header("Location: ../#cuenta");
} elseif (isset($_REQUEST['editar_usuario'])) {
	$cuenta_usuario = $_REQUEST["cuenta_usuario"];
	$archivo = 'usuarios.php';
	$content = file_get_contents($archivo);
	$content = str_replace($G,$cuenta_usuario,$content);
	file_put_contents($archivo,$content);
	$_SESSION['usuario'] = $cuenta_usuario;
	header("Location: ../#cuenta");
} elseif (isset($_REQUEST['editar_correo'])) {
	$cuenta_correo = $_REQUEST["cuenta_correo"];
	$archivo = 'usuarios.php';
	$content = file_get_contents($archivo);
	$content = str_replace($Correo,$cuenta_correo,$content);
	file_put_contents($archivo,$content);
	$_SESSION['correo'] = $cuenta_correo;
	header("Location: ../#cuenta");
} elseif (isset($_REQUEST['editar_rango'])) {
	$cuenta_rango = $_REQUEST["cuenta_rango"];
	$archivo = 'usuarios.php';
	$content = file_get_contents($archivo);
	$content = str_replace($Rango,$cuenta_rango,$content);
	file_put_contents($archivo,$content);
	$_SESSION['rango'] = $cuenta_rango;
	header("Location: ../#cuenta");
} elseif (isset($_REQUEST['editar_imagen'])) {
	$cuenta_imagen = $_REQUEST["cuenta_imagen"];
	$archivo = 'usuarios.php';
	$content = file_get_contents($archivo);
	$content = str_replace($Imagen,$cuenta_imagen,$content);
	$_SESSION['imagen'] = $cuenta_imagen;
	file_put_contents($archivo,$content);

	header("Location: ../#cuenta");
} elseif (isset($_REQUEST['pass_old']) && isset($_REQUEST['pass_new'])) {
	$pass_new = sha1($_REQUEST["pass_new"]);
	$archivo = 'usuarios.php';
	$content = file_get_contents($archivo);
	$content = str_replace($Contraseña,$pass_new,$content);
	file_put_contents($archivo,$content);
	$_SESSION['contrasena'] = $pass_new;
	header("Location: ../#cuenta");
} else {
	header("Location: ../#error");
	$_SESSION['error'] = "error";
}
?>