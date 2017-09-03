<?php
if (isset($_SESSION['usuario'])) {
	$G = $_SESSION['usuario'];
}

$post = file_get_contents(realpath('../posts/posts.json'));
$getJSON = json_decode($post);
$user = file_get_contents(realpath('../admin/php/usuarios.json'));
$userGetJSON = json_decode($user);
$contarIndicesJSON = count($getJSON->post);

foreach ($getJSON as $post) {
  for ($i = 0; $i < $contarIndicesJSON; $i++) {
  	$idUser = $post[$i]->datos->id;
		$getUser = $userGetJSON->usuarios[$idUser];

  	$html = "<div class='post' id='post' data-id='".$post[$i]->id."' style='display: block;'>
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
	  <div id='enlace'><a href='http://" . $host . $uri."/../posts/".$post[$i]->url."' title='Ver Post'><i class='fa fa-eye' aria-hidden='true'></i></a></div>
	  </div>
		</div>

		";

		if (isset($_REQUEST['url'])) {
		$buscador   = $_REQUEST['url'];
		} else {
		$buscador = NULL;
		}

		$titulo = $post[$i]->contenido;
		$destacado = $post[$i]->info->destacado;
		$catJSON = $post[$i]->info->categoria;
		$tituloRep = str_ireplace(array('á', 'é', 'í', 'ó', 'ú'), array('a', 'e', 'i', 'o', 'u'), $titulo);
		if (preg_match("/$buscador/i", "$tituloRep") && $destacado === "no") {
			echo $html;
		}

	}
} //Fin Foreach
?>