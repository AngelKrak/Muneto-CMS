<?php
if (isset($_SESSION['usuario'])) {
	$G = $_SESSION['usuario'];
}

$post = file_get_contents(realpath('posts/posts.json'));
$getJSON = json_decode($post);
$user = file_get_contents(realpath('admin/php/usuarios.json'));
$userGetJSON = json_decode($user);
$contarIndicesJSON = count($getJSON->post);
$uri = str_ireplace('index.php', '', $_SERVER['REQUEST_URI']);
$uriA = explode("/", $uri);
(in_array("categoria", $uriA)) ? $ruta = '../php/ame.php' : $ruta = 'php/ame.php';
(in_array("categoria", $uriA)) ? $rutaPost = '../' : $rutaPost = '';

foreach ($getJSON as $post) {
  for ($i = 0; $i < $contarIndicesJSON; $i++) {
  	$idUser = $post[$i]->datos->id;
		$getUser = $userGetJSON->usuarios[$idUser];

  	$html = "<div class='post' id='post' data-id='".$post[$i]->id."'>
	  <div id='titulo'>".$post[$i]->datos->titulo."</div>
	  <div class='date'>
	    <div id='dia' class='day' data-dia='".$post[$i]->fecha->dia."' data-year='". $post[$i]->fecha->completa ."' data-fecha='". $post[$i]->fecha->completa ."'>".$post[$i]->fecha->dia."</div>
	    <div class='month'>". substr($post[$i]->fecha->mes, 0, 3) ."</div>
	  </div>
	  <img src='".$post[$i]->datos->portada."' id='imagen' width='100%' />
	  <div id='de'>".$post[$i]->datos->descripcion."</div>
	  <div id='autor' class='". strtolower($getUser->usuario) ."'>By <strong>".$getUser->usuario."</strong></div>
	  <div id='hora'><i class='fa fa-clock-o'></i>". $post[$i]->fecha->hora_publicacion."</div>
	  <div id='cont_link'>
	  <div id='enlace'><a href='".$rutaPost."posts/".$post[$i]->url."' title='Ver Post'><i class='fa fa-eye' aria-hidden='true'></i></a></div>";
	  if($Rango == "Administrador"){
	  $html .=  "
	  <div style='border-right: 1px solid #ddd'></div>
	  <div id='desc'><a href='#' id='des' data-idEliminar='".$post[$i]->id."' data-ruta='".$ruta."' class='eliminarPost' title='Eliminar Post'><i class='fa fa-times' aria-hidden='true'></i></a></div>";
	  }
	  $html .=  "
	  </div>
		</div>

		";

		if (isset($_REQUEST['buscar'])) {
		$buscador   = $_REQUEST['buscar'];
		} else {
		$buscador = NULL;
		}
		if (isset($_REQUEST['cat'])) {
		$cat   = $_REQUEST['cat'];
		} else {
		$cat = NULL;
		}

		$titulo = $post[$i]->datos->titulo;
		$destacado = $post[$i]->info->destacado;
		$catJSON = $post[$i]->info->categoria;
		$tituloRep = str_ireplace(array('á', 'é', 'í', 'ó', 'ú'), array('a', 'e', 'i', 'o', 'u'), $titulo);
		if (preg_match("/$buscador/i", "$tituloRep") && $destacado === "si" && $buscador != NULL) {
			echo $html;
		}
		if (preg_match("/$cat/i", "$catJSON") && $destacado === "si" && $cat != NULL) {
			echo $html;
		}
		if ($cat == NULL && $buscador == NULL && $destacado === "si") {
			echo $html;
		}

	}
} //Fin Foreach
?>