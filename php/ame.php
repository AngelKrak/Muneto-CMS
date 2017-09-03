<?php
session_start();
@$G = $_SESSION['usuario'];
@$Rango = $_SESSION['rango'];
?>
<?php
function securePost($variable) {
  $securePost = htmlentities($variable, ENT_QUOTES, 'utf-8');
  return $securePost;
}
if (!file_exists('../posts/posts.json')) {
  $crearPosts = fopen("../posts/posts.json", 'w') or die("Error al abrir fichero de salida");
  fwrite($crearPosts, '{
  "post": [
    
  ]
}');
  fclose($crearPosts);
}
if (!file_exists('../trash/trash.json')) {
  $crearPostsTrash = fopen("../trash/trash.json", 'w') or die("Error al abrir fichero de salida");
  fwrite($crearPostsTrash, '{
  "post": [
    
  ]
}');
  fclose($crearPostsTrash);
}

if (isset(securePost($_POST['agregarPost']))) {
$str = array(" ", "[", "]", "!", "¡", "--", ".", 'á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä', 'é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë', 'í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î', 'ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô', 'ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü', 'ñ', 'Ñ', 'ç', 'Ç', "\\", "¨", "º", "~", "#", "@", "|", "!", '"', "·", "$", "%", "&", "/", "(", ")", "?", "'", "¡", "¿", "[", "^", "<code>", "]", "+", "}", "{", "¨", "´", ">", "<", ";", ",", ":");
$titulo_url = strtolower(str_replace($str, '-', securePost($_POST['titulo'])));
$autor = securePost($_POST['autor']);
$post = file_get_contents('../posts/posts.json');
$getJSON = json_decode($post);
$contarIndicesJSON = count($getJSON->post);

foreach ($getJSON as $key) {
  for ($i = 0; $i < $contarIndicesJSON; $i++) {
    $tituloJSON = $key[$i]->url;
    $autorJSON = $key[$i]->datos->id;
    if (preg_match("/$titulo_url\b/", "$tituloJSON") && preg_match("/$autor\b/", "$autorJSON")) {
      echo "<div id='Agregarsuccess' class='alert alert-warning' role='alert'>¡¡Error!! El Post ya Existe</div>";
      return false;
    }
  }
}

echo "<div id='Agregarerror' class='alert alert-danger' role='alert' style='margin-top: 65px;margin-bottom: 10px;'></div><div id='Agregarsuccess' class='alert alert-success' role='alert'>El Post ha sido Creado</div>";

$titulo = securePost($_POST['titulo']);
$descripcion = securePost($_POST['descripcion']);
$imagen = securePost($_POST['imagen']);
$img_autor = securePost($_POST['img_autor']);
$autor = securePost($_POST['autor']);
//Buscamos codigo PHP y lo BORRAMOS
$contenido = preg_replace("[\n|\r|\n\r]", '', securePost($_POST['contenido']));
$contenido = preg_replace('/<\?php(.*?)\?>/', ' ', $contenido);
//Buscamos Comillas Simples y las Ignoramos
$contenido_replace2 = array('"');
$contenido2 = str_replace($contenido_replace2, "'", $contenido);
$fecha = securePost($_POST['fecha']);
$hora = securePost($_POST['hora']);
$tags = securePost($_POST['tags']);
$categoria = securePost($_POST['categoria']);

$data_dia = securePost($_POST['DataDia']);
$data_mes = securePost($_POST['DataMes']);
}

$str_datos = file_get_contents("../posts/posts.json");
$datos = json_decode($str_datos, true);
$_size = count($datos["post"]);

$ID = $_size;
(isset(securePost($_POST['ideliminar']))) ? $IDJSON = securePost($_POST['ideliminar']) : $IDJSON = NULL;
$i=0;

    // Movemos el Post a la Papelera
    if (isset(securePost($_POST['eliminar']))) {
      $trash_datos = file_get_contents("../trash/trash.json");
      $datosPostTrash = json_decode($trash_datos, true);
      $str_datos = file_get_contents("../posts/posts.json");
      $datos = json_decode($str_datos, true);
      @$idExist = $datos["post"][$IDJSON];
      if ($idExist === NULL) {
        echo '<div class="alert alert-danger fade in" data-id="'.$IDJSON.'"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>¡Error al Eliminar!</strong> El Post no Existe</div>';
        return false;
      }
      echo '<div class="alert alert-success fade in" data-id="'.$IDJSON.'"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> Se ha Eliminado el Post <strong style="display:block;">'.$datos["post"][$IDJSON]['datos']['titulo'].'</strong></div>';

      $postTrash = $datos["post"][$IDJSON];
      array_push($datosPostTrash["post"], $postTrash);
      $trash = fopen("../trash/trash.json", 'w') or die("Error al abrir fichero de salida");
      fwrite($trash, json_encode($datosPostTrash, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
      fclose($trash);

      // Eliminar Post previamente y Guardar posts de nuevo
      $postsURL = file_get_contents('../posts/posts.json');
      $postsJSON = json_decode($postsURL);

      $results = count($postsJSON->post);
      for ($r = 0; $r < $results; $r++) {
        if ($postsJSON->post[$r]->id == $IDJSON) {
          unset($postsJSON->post[$r]);
          break;
        }
      }

      $postsJSON->post = array_values($postsJSON->post);
      $posts = fopen("../posts/posts.json", 'w') or die("Error al abrir fichero de salida");
      fwrite($posts, json_encode($postsJSON, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
      fclose($posts);

      unset($postsJSON, $datosPostTrash); // Liberar Memoria
      return false;
    }

    // Editamos los Datos del POST
    if (isset(securePost($_POST['editar']))) {
      $contenidoPost = str_ireplace('"', "'", securePost($_POST['new']));
      $tituloPost = securePost($_POST['titulop']);
      $descripcionPost = securePost($_POST['descripcionp']);
      $portadaPost = securePost($_POST['portadap']);
      $tagsPost = securePost($_POST['tagsp']);
      $categoriaPost = securePost($_POST['categoriap']);

      $postsURL = file_get_contents('../posts/posts.json');
      $editarPost = json_decode($postsURL);
      $contarPost = count($editarPost->post);
      for ($e = 0; $e < $contarPost; $e++) {
        if ($editarPost->post[$e]->id == $IDJSON) {
          $editarPost->post[$e]->contenido = $contenidoPost;
          $editarPost->post[$e]->datos->titulo = $tituloPost;
          $editarPost->post[$e]->datos->descripcion = $descripcionPost;
          $editarPost->post[$e]->datos->portada = $portadaPost;
          $editarPost->post[$e]->info->tags = $tagsPost;
          $editarPost->post[$e]->info->categoria = $categoriaPost;
          break;
        }
      }

      $posts = fopen("../posts/posts.json", 'w') or die("Error al abrir fichero de salida");
      fwrite($posts, json_encode($editarPost, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
      fclose($posts);

      return false;
    }

    // Destacamos o No el POST
    if (isset(securePost($_POST['destacar']))) {
      $destacar = securePost($_POST['destacar']);

      $postsURL = file_get_contents('../posts/posts.json');
      $destacarPost = json_decode($postsURL);
      $contarPost = count($destacarPost->post);
      for ($d = 0; $d < $contarPost; $d++) {
        if ($destacarPost->post[$d]->id == $IDJSON) {
          $destacarPost->post[$d]->info->destacado = $destacar;
          break;
        }
      }

      $posts = fopen("../posts/posts.json", 'w') or die("Error al abrir fichero de salida");
      fwrite($posts, json_encode($destacarPost, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
      fclose($posts);

      return false;
    }

    // Eliminamos el Post Permanente
    if (isset(securePost($_POST['delForever']))) {
      $titulo = securePost($_POST['tituloPost']);

      $postsURL = file_get_contents('../trash/trash.json');
      $delForever = json_decode($postsURL);
      echo '<div class="alert alert-success fade in" data-id="'.$IDJSON.'"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> Se ha Eliminado el Post <strong style="display:block;">'. $delForever->post[$IDJSON]->datos->titulo .'</strong></div>';

      $contarPost = count($delForever->post);
      for ($e = 0; $e < $contarPost; $e++) {
        if ($delForever->post[$e]->id == $IDJSON) {
          unset($delForever->post[$e]);
          break;
        }
      }

      $posts = fopen("../trash/trash.json", 'w') or die("Error al abrir fichero de salida");
      fwrite($posts, json_encode($delForever, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
      fclose($posts);
      return false;
    }

    // Publicamos el Post de Nuevo (Trash)
    if (isset(securePost($_POST['paburisshu']))) {
      $trash_datos = file_get_contents("../trash/trash.json");
      $datosPostTrash = json_decode($trash_datos, true);
      $str_datos = file_get_contents("../posts/posts.json");
      $datos = json_decode($str_datos, true);
      @$idExist = $datos["post"][$IDJSON];
      if ($idExist === NULL) {
        echo '<div class="alert alert-danger fade in" data-id="'.$IDJSON.'"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>¡Error al Publicar!</strong> El Post no Existe</div>';
        return false;
      }
      echo '<div class="alert alert-success fade in" data-id="'.$IDJSON.'"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> Se ha Publicado el Post <strong style="display:block;">'.$datosPostTrash["post"][$IDJSON]['datos']['titulo'].'</strong></div>';

      $postTrash = $datosPostTrash["post"][$IDJSON];
      array_push($datos["post"], $postTrash);
      $trash = fopen("../posts/posts.json", 'w') or die("Error al abrir fichero de salida");
      fwrite($trash, json_encode($datos, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
      fclose($trash);

      // Eliminar Post previamente y Guardar posts de nuevo
      $postsURL = file_get_contents('../trash/trash.json');
      $postsJSON = json_decode($postsURL);

      $results = count($postsJSON->post);
      for ($r = 0; $r < $results; $r++) {
        if ($postsJSON->post[$r]->id == $IDJSON) {
          unset($postsJSON->post[$r]);
          break;
        }
      }

      $postsJSON->post = array_values($postsJSON->post);
      $posts = fopen("../trash/trash.json", 'w') or die("Error al abrir fichero de salida");
      fwrite($posts, json_encode($postsJSON, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
      fclose($posts);

      unset($postsJSON, $datosPostTrash); // Liberar Memoria
      return false;
    }

if (isset(securePost($_POST['agregarPost']))) {
  foreach ($datos["post"] as $key => $value) {
      // Agregamos el Nuevo Post
      if($value["id"] !== $ID) {
          $i++; // incrementa la posición $i      
           // Verifica si el el tamaño de empleado es igual a $i, esto para evitar detalle de error
          if( $_size === $i ){
              // echo "No existe agregando"; 
              // Agrego un nuevo valor al array empleado
              $datosA = array('titulo'=> $titulo, 'descripcion'=> $descripcion, 'portada'=> $imagen, 'id'=> $autor);
              $fechaA = array('dia'=> $data_dia, 'mes'=> $data_mes, 'completa'=> $fecha, 'hora_publicacion' => $hora);
              $infoA = array('destacado'=> 'no', 'tags'=> $tags, 'categoria'=> $categoria, 'imagen'=> $img_autor);
              $post = array('id'=> $ID, 'contenido'=> $contenido2, 'url'=> $titulo_url, 'datos' => $datosA, 'fecha'=> $fechaA, 'info'=> $infoA);
              array_push($datos["post"], $post);
          }
      }
     
  }

  $posts = fopen("../posts/posts.json", 'w') or die("Error al abrir fichero de salida");
  fwrite($posts, json_encode($datos, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
  fclose($posts);
}
?>