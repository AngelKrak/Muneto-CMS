<?php
session_start();

$nick = htmlentities($_REQUEST['nick']);
$pass = htmlentities($_REQUEST['pass']);
$passHash = password_hash($pass, PASSWORD_BCRYPT);
$valido = false;

$usuariosURL = file_get_contents('usuarios.json');
$usuariosJSON = json_decode($usuariosURL);

for ($i = 0; $i < count($usuariosJSON->usuarios); $i++) {
	if ($usuariosJSON->usuarios[$i]->usuario == $nick || $usuariosJSON->usuarios[$i]->datos_personales->email == $nick) {
		if (password_verify($pass, $usuariosJSON->usuarios[$i]->contrasena)) {
			$valido = true;
			$_SESSION['usuario'] = '$usuariosJSON->usuarios['.$i.']->usuario';
			$_SESSION['correo'] = '$usuariosJSON->usuarios['.$i.']->datos_personales->email';
			$_SESSION['contrasena'] = '$usuariosJSON->usuarios['.$i.']->contrasena';
			$_SESSION['rango'] = '$usuariosJSON->usuarios['.$i.']->rango';
			$_SESSION['imagen'] = '$usuariosJSON->usuarios['.$i.']->datos_personales->imagen_perfil';
			$_SESSION['nombre'] = '$usuariosJSON->usuarios['.$i.']->datos_personales->nombre';
			$_SESSION['idAutor'] = '$usuariosJSON->usuarios['.$i.']->id';
			break;
		} else {
			$contrasena_incorrecta = '<div class="alert alert-danger fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>¡Error al Iniciar Sesion!</strong> La Contraseña es Incorrecta</div>';
		}
	} else {
		$usuario_incorrecto = '<div class="alert alert-danger fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>¡Error al Iniciar Sesion!</strong> El Usuario es Incorrecto</div>';
	}
}

if ($valido == true) {
  $datos_correctos = '<div class="alert alert-success fade in valido"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Los Datos Ingresados fueron Correctos</div>';
	echo $datos_correctos;
	return false;
}
if (isset($contrasena_incorrecta))
	echo $contrasena_incorrecta;
else 
	echo $usuario_incorrecto;
?>
