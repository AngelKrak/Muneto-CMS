<?php
if (isset($_SESSION['usuario'])) {
	$G = $_SESSION['usuario'];
}

$post = file_get_contents(realpath('../trash/trash.json'));
$getJSON = json_decode($post);
$user = file_get_contents(realpath('admin/php/usuarios.json'));
$userGetJSON = json_decode($user);
$contarIndicesJSON = count($getJSON->post);

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
	  <div id='enlace'><a href='http://" . $host . $uri."/posts/".$post[$i]->url."' data-idpublicar='".$post[$i]->id."' class='publicar now' title='Publicar Post'><i class='fa fa-plus' aria-hidden='true'></i></a></div>";
	  if($Rango == "Administrador"){
	  $html .=  "
	  <div style='border-right: 1px solid #ddd'></div>
	  <div id='desc'><a href='#' id='des' data-ideliminar='".$post[$i]->id."' class='eliminar forever' title='Eliminar Post'><i class='fa fa-times' aria-hidden='true'></i></a></div>";
	  }
	  $html .=  "
	  </div>
		</div>

		";

		echo $html;
	}
} //Fin del Foreach
?>