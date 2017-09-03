<?php
	if (isset($_REQUEST['gestionarDB'])) {
		$rutaDB = $_REQUEST['rutaDB'];

		$abrirDB = file_get_contents(realpath($rutaDB));
		$dbToJson = json_decode($abrirDB);
		echo '<div id="posts" style="width: 100%;justify-content: flex-start;max-height: 290px;overflow: auto;">';
		foreach ($dbToJson->post as $post) {
			$html = "<div class='post' id='post' data-id='".$post->id."'>
	  <div id='titulo'>".$post->datos->titulo."</div>
	  <div class='date'>
	    <div id='dia' class='day' data-dia='".$post->fecha->dia."' data-year='". $post->fecha->completa ."' data-fecha='". $post->fecha->completa ."'>".$post->fecha->dia."</div>
	    <div class='month'>". substr($post->fecha->mes, 0, 3) ."</div>
	  </div>
	  <img src='".$post->datos->portada."' id='imagen' width='100%' />
	  <div id='de'>".$post->datos->descripcion."</div>
	  <div id='autor' class='". strtolower($post->datos->autor) ."'>By <strong>".$post->datos->autor."</strong></div>
	  <div id='hora'><i class='fa fa-clock-o'></i>". $post->fecha->hora_publicacion."</div>
	  <div id='cont_link'>
	  <div id='enlace'><a href='#' title='Publicar Post'><i class='fa fa-plus' aria-hidden='true'></i></a></div>
	  </div>
		</div>

		";
		echo $html;
		}
		echo '</div>';
	}
?>