<?php
session_start();
if (!file_exists(realpath("../admin/php/usuarios.json")))
  header('Location: ../index.php');
else if (!file_exists(realpath("../posts/posts.json")))
  header('Location: ../index.php');
else
	$url = htmlentities($_REQUEST['url']);
	$post = file_get_contents(realpath('../posts/posts.json'));
	$getJSON2 = json_decode($post);
  $user = file_get_contents(realpath('../admin/php/usuarios.json'));
  $userGetJSON = json_decode($user);
  for($i = 0; $i < count($getJSON2->post); $i++) {
    if ($getJSON2->post[$i]->url == $url) {
      $getJSON = $getJSON2->post[$i];
      break;
    }
  }
  $_SESSION['url'] = $url;
?>
<?php
$usuariosURL = file_get_contents('../admin/php/usuarios.json');
$usuariosJSON = json_decode($usuariosURL);
if (isset($_SESSION['usuario'])) {
  $G = eval('return '. $_SESSION['usuario']. ';');
  $Rango = eval('return '. $_SESSION['rango']. ';');
} else {
  $G = NULL;
  $Rango = NULL;
}
$host  = $_SERVER['HTTP_HOST'];
$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
?>
<?php require '../php/config.php'; ?>
<?php
  if (isset($getJSON)) {
    $idUser = $getJSON->datos->id;
    $getUser = $userGetJSON->usuarios[$idUser];
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, user-scalable=no">
  <meta name="description" content="<?php echo $getJSON->datos->descripcion; ?>">
  <title><?php echo $getJSON->datos->titulo; ?> | <?php echo $titulo_web; ?></title>
  <meta property="og:title" content="<?php echo $getJSON->datos->titulo; ?>">
  <meta property="og:type" content="article">
  <meta property="og:image" itemprop="image" content="<?php echo $getJSON->datos->portada; ?>">
  <meta property="og:description" content="<?php echo $getJSON->datos->descripcion; ?>">
  <meta name="twitter:image" content="<?php echo $getJSON->datos->portada; ?>"> 

  <link href="http://getbootstrap.com/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="../Librerias/bootstrap.min.css" rel="stylesheet">

  <link rel="stylesheet" type="text/css" href="https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.css">
  <link rel="stylesheet" type="text/css" href="../Librerias/bootstrap-tagsinput.css">

  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.css">
  <link rel="stylesheet" type="text/css" href="../Librerias/font-awesome.css">

  <link rel="stylesheet" type="text/css" href="../themes/<?php echo $tema_select; ?>/css/post.css">
  <link rel="stylesheet" type="text/css" href="../themes/<?php echo $tema_select; ?>/css/icomoon.css">
</head>
<body>
<link itemprop="thumbnailUrl" href="<?php echo $getJSON->datos->portada; ?>">
<span itemprop="thumbnail" itemscope itemtype="http://schema.org/ImageObject">
  <link itemprop="url" href="<?php echo $getJSON->datos->portada; ?>">
</span>

<?php include '../includes/nav2.php'; ?>

<div class="container">
<div class="template">
  <div class="post" id="post">
    <div id="titulo"><?php echo $getJSON->datos->titulo; ?></div>
    <img src="<?php echo $getJSON->datos->portada; ?>" id="imagen" Width="100%" />
    <div id="de"><?php echo $getJSON->datos->descripcion; ?></div>
    <div id="autor"><?php echo $getUser->usuario; ?></div>
    <div id="fecha" data-day="<?php echo $getJSON->fecha->dia; ?>" data-mes="<?php echo $getJSON->fecha->mes; ?>"><?php echo $getJSON->fecha->completa; ?></div>
    <div id="hora">12:28:01 AM</div>
    <div id='destacado' data-destacado='<?php echo $getJSON->info->destacado; ?>'></div>
    <div id="tags"><input type="text" data-role="tagsinput" value="<?php echo $getJSON->info->tags; ?>"/></div>
    <div id="categoria"><?php echo $getJSON->info->categoria; ?></div>
  </div>

<div id="sidebar">
<div class="info">
<div class="info_imagen"><img src="<?php echo $getUser->datos_personales->imagen_perfil; ?>" id="imagen" Width="100%" /></div>
<div class="info_autor"><span class="icon-user-check icon"></span> <span id="autor_text"><?php echo $getUser->usuario; ?></span></div>
<div class="info_fecha"><span class="icon-calendar icon"></span> <span id="fecha_text"><?php echo $getJSON->fecha->completa; ?></span></div>
<div class="info_hora"><span class="icon-clock icon"></span> <span id="hora_text"><?php echo $getJSON->fecha->hora_publicacion; ?></span></div>
<?php
  if ($G == "AngelKrak" || $Rango == "Administrador") {
?>
<div class="Contenedor_Editar_Post">
  <button type="button" class="editarPost btn btn-primary btn-block" data-ideliminar="<?php echo $getJSON->id; ?>" style="font-family:'Roboto';padding: 10px 18px;font-size: 14px;"><i class="fa fa-pencil" aria-hidden="true"></i> Editar Post</button>
  <button type="button" class="eliminarPost btn btn-danger btn-block" data-ideliminar="<?php echo $getJSON->id; ?>" style="font-family:'Roboto';padding: 10px 18px;font-size: 14px;"><i class="fa fa-times" aria-hidden="true"></i> Eliminar Post</button>
  <button type="button" class="star btn btn-warning btn-block" data-ideliminar="<?php echo $getJSON->id; ?>" style="font-family:'Roboto';padding: 10px 18px;font-size: 14px;"><i class="fa fa-star-o" aria-hidden="true"></i> </button>
</div>
<?php } ?>
</div>
<div class="button_social_plugins">
<div class="fb-like" data-href="<?php echo "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>" data-layout="box_count" data-action="like" data-size="small" data-show-faces="true" data-share="false"></div>
<div class="fb-share-button" data-href="<?php echo "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>" data-layout="box_count" data-size="small" data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore" target="_blank">Compartir</a></div>

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v2.7&appId=1634733356810512"; //Cambiar esta
  fjs.parentNode.insertBefore(js, fjs);
}(document, "script", "facebook-jssdk"));</script>
</div>
</div>

<div class="post_content">
<h1 class="post_content_titulo"><?php echo $getJSON->datos->titulo; ?></h1>
<div class="muneto_contenido"><?php echo $getJSON->contenido; ?></div>
</div>

</div>

<div class="tags category">
<div class="categorias">
Categoria: <strong><?php echo $getJSON->info->categoria; ?></strong>
</div>
<div class="tagss">
Tags: <span class="conte_tags"></span>
</div>
</div>

<div class="post_comment">
<div id="disqus_thread"></div>
<script>
(function() { // DON'T EDIT BELOW THIS LINE
var d = document, s = d.createElement("script");

s.src = "//muneto.disqus.com/embed.js";

s.setAttribute("data-timestamp", +new Date());
(d.head || d.body).appendChild(s);
})();
</script>
<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript" rel="nofollow">comments powered by Disqus.</a></noscript>
<script id="dsq-count-scr" src="//muneto.disqus.com/count.js" async></script>
</div>

<?php
  include "../includes/footer.php";
?>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.js"></script>
<script src="../Librerias/jquery.js"></script>

<script src="http://getbootstrap.com/dist/js/bootstrap.min.js"></script>
<script src="../Librerias/bootstrap.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>
<script src="https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
<script src="../Librerias/typeahead.bundle.min.js"></script>
<script src="../Librerias/bootstrap-tagsinput.min.js"></script>

<script src="../themes/<?php echo $tema_select; ?>/js/post.js"></script>
</body>
</html>
<?php
  } else {
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta name="viewport" content="width=device-width, user-scalable=no">
  <meta charset="UTF-8">
  <meta name="robots" content="noindex, follow" />
  <title><?php echo $titulo_web; ?> | <?php echo $slogan; ?></title>
  <link href="http://getbootstrap.com/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.css">
  <link rel="stylesheet" type="text/css" href="../themes/<?php echo $tema_select; ?>/css/post.css">
  <link rel="stylesheet" type="text/css" href="../themes/<?php echo $tema_select; ?>/css/icomoon.css">
</head>
<body>
<?php include '../includes/nav2.php'; ?>

<div class="container">
<div class="template">
  <div class="post_content">
    <h1 class="post_content_titulo">El Post que Buscas no Existe o Fue Eliminado!
<span class="sug">Pero no pierdas las Esperanzas, Te Dejamos unas Sugerencias!</span></h1>
    <div id="posts">
      <?php include '../includes/posts_sugeridos.php'; ?>
    </div>
  </div>
</div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.js"></script>
<script src="http://getbootstrap.com/dist/js/bootstrap.min.js"></script>
</body>
</html>
<?php
  }
?>