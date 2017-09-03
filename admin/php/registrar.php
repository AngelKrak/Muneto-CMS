<?php
	session_start();

	if (isset($_POST['agregarUsuario'])) {
		$nombre = htmlentities($_POST['nameR'], ENT_QUOTES, 'utf-8');
		$usuario = htmlentities($_POST['nickR'], ENT_QUOTES, 'utf-8');
		$email = htmlentities($_POST['emailR'], ENT_QUOTES, 'utf-8');
		$contra = password_hash($_POST['passR'], PASSWORD_BCRYPT);
		$imagen = htmlentities($_POST['imageR'], ENT_QUOTES, 'utf-8');

		$str_datos = file_get_contents("usuarios.json");
		$usuariosJSON = json_decode($str_datos, true);
		$_size = count($usuariosJSON["usuarios"]);
		$ID = $_size;
		$i=0;

	  foreach ($usuariosJSON["usuarios"] as $key => $value) {
	      if($value["id"] !== $ID) {
	          $i++;
	          if($_size === $i) {
	              $datosPesonales = array('email' => $email, 'imagen_perfil' => $imagen, 'nombre' => $nombre);
	              $usuario = array('id' => $ID, 'usuario' => $usuario, 'contrasena' => $contra, 'rango' => 'Munetin', 'datos_personales' => $datosPesonales);
	              array_push($usuariosJSON["usuarios"], $usuario);
	          }
	      }
	  }

	  if (empty($nombre) or $nombre == '') {
	  	$datos_correctos = '<div class="alert alert-warning fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>¡Error al Registrarse!</strong> El Usuario ya existe!</div>';
			echo $datos_correctos;
			return false;
		}

		if (empty($nombre) or $nombre == '') {
	  	$datos_correctos = '<div class="alert alert-danger fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>¡Error al Registrarse!</strong> El Nombre no puede estar vacio!</div>';
			echo $datos_correctos;
			return false;
		} else if (empty($usuario) or $usuario == '') {
	  	$datos_correctos = '<div class="alert alert-danger fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>¡Error al Registrarse!</strong> El Usuario no puede estar vacio!</div>';
			echo $datos_correctos;
			return false;
		} else if (empty($email) or $email == '') {
	  	$datos_correctos = '<div class="alert alert-danger fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>¡Error al Registrarse!</strong> El Correo Electronico no puede estar vacio!</div>';
			echo $datos_correctos;
			return false;
		} else if (empty($_POST['passR']) or $_POST['passR'] == '') {
	  	$datos_correctos = '<div class="alert alert-danger fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>¡Error al Registrarse!</strong> La Contraseña no puede estar vacia!</div>';
			echo $datos_correctos;
			return false;
		} else if (empty($imagen) or $imagen == '') {
	  	$datos_correctos = '<div class="alert alert-danger fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>¡Error al Registrarse!</strong> La Imagen no puede estar vacia!</div>';
			echo $datos_correctos;
			return false;
	  } else if ($usuariosJSON["usuarios"][$ID]["id"] == $ID) {
		  $datos_correctos = '<div class="alert alert-success fade in valido"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Te has registrado correctamente!</div>';
			echo $datos_correctos;
			$_SESSION['usuario'] = '$usuariosJSON->usuarios['.$ID.']->usuario';
			$_SESSION['correo'] = '$usuariosJSON->usuarios['.$ID.']->datos_personales->email';
			$_SESSION['contrasena'] = '$usuariosJSON->usuarios['.$ID.']->contrasena';
			$_SESSION['rango'] = '$usuariosJSON->usuarios['.$ID.']->rango';
			$_SESSION['imagen'] = '$usuariosJSON->usuarios['.$ID.']->datos_personales->imagen_perfil';
			$_SESSION['nombre'] = '$usuariosJSON->usuarios['.$ID.']->datos_personales->nombre';
			$_SESSION['idAutor'] = '$usuariosJSON->usuarios['.$ID.']->id';
			$posts = fopen("usuarios.json", 'w') or die("Error al abrir fichero de salida");
		  fwrite($posts, json_encode($usuariosJSON, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
		  fclose($posts);
			return false;
		}
	}

	header("Location: ../index.php");
?>