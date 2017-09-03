<?php
require 'php/config.php';
require 'includes/copy.php';
$usuariosURL = file_get_contents('admin/php/usuarios.json');
$usuariosJSON = json_decode($usuariosURL);

//Iniciamos Sesion y Obtenemos los Datos del Usuario Iniciado
session_start();
@$G = eval('return '. $_SESSION['usuario']. ';');
@$Rango = eval('return '. $_SESSION['rango']. ';');

if ($Copyright == '<a href="https://facebook.com/angelkrak92" target="_blank"><b>Angel Komander</b></a>') {
$host  = $_SERVER['HTTP_HOST'];
$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$dir = 'http://' . $host . $uri;
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no">
    <title><?php echo $titulo_web; ?> | <?php echo $slogan; ?></title>
    <meta name="description" content="Muneto es un Pequeño CMS que esta en Version Alpha hecho con PHP y AJAX sin MYSQL(Base de Datos)">
    <!-- Bootstrap core CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.css">
    <link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="<?php echo $dir.'/themes/'. $tema_select; ?>/css/style.css">
  </head>

  <body>
  <!-- Modal -->
  <div class="modal fade" id="Modal_Muneto" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Donativos al Creador</h4>
        </div>
        <div class="modal-body" style="white-space: normal;">
          <p>Si te ha Gustado el Mini CMS puedes hacer una Donacion para darle las Gracias al Creador.<br />
          Gracias por haber Descargado y Donado en este Proyecto :D</p>
          <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&amp;hosted_button_id=JUREESC824Q3S" target="_blank"><img src="https://camo.githubusercontent.com/24ae43518013d5c9306ddadbbc2fdea234d3522c/68747470733a2f2f7777772e70617970616c6f626a656374732e636f6d2f656e5f55532f47422f692f62746e2f62746e5f646f6e61746543435f4c472e676966" alt="Donate" data-canonical-src="https://www.paypalobjects.com/en_US/GB/i/btn/btn_donateCC_LG.gif" style="max-width:100%;"></a>
          <p style="text-align: right;"><strong>By AngelKrak</strong></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
<?php 
//Incluimos el Menu de Navegacion
require_once 'includes/nav.php'; ?>

<div class="container">
<div class="template">
<noscript>
  <h2>Lo Siento! Tu navegador no Soporta o no Tiene Activado Javascript.</h2>
</noscript>
<div id='mensajes'>
<div id='error' class='alert' role='alert'></div>
</div>

<aside id="estadisticas">
  <form method="get" action="<?php echo $dir; ?>">
    <input type="search" name="buscar" class="form-control" placeholder="Buscar..." style="margin: 0;margin-bottom: 20px;height: 44px;text-transform: none;font-weight: normal;">
  </form>
  <h1 class="titulo">Estadisticas</h1>
	<div class="total posts"></div>
	<?php
  if(@$Rango){ echo '
  <div class="total usuario"></div>';
  }
  ?>
	<div class="total hoy"></div>

  <div class="categoriasSelect">
    <div class="cat default">Todas las Categorias</div>
    <div class="cats" style="display: none;">
    <?php
      require 'admin/php/categorias.php';
      asort($categorias);
      $contarCat = count($categorias);

      $post = file_get_contents(realpath('posts/posts.json'));
      $getJSON = json_decode($post);
      $contarIndicesJSON = count($getJSON->post);

      

      foreach ($categorias as $categoria) {
        foreach ($getJSON as $key) {
        for ($i = 0; $i < $contarIndicesJSON; $i++) {
          if ($key[$i]->info->categoria === $categoria) {
            $cat[] = $key[$i]->info->categoria;
          }
        }
        echo '<a href="'.$dir.'/categoria/'.$categoria.'" class="cat">'.$categoria.'<span class="countCat">'.count($cat).'</span></a>';
        $cat = null;
      }
      }
    ?>
    </div>
  </div>
</aside>

<div id="posts">
<div id="destacados" style="display: flex;-webkit-flex: 5 5 100%;flex: 5 5 100%;flex-wrap: wrap;align-items: flex-start;">
<h2 style="margin-top:0;flex: 1 100%;background: #222;padding: 10px;color: #ddd;font-family: 'Roboto';font-size: 20px;">Destacados <i class="fa fa-star-o" aria-hidden="true" style="vertical-align: baseline;float: right;"></i></h2>
<?php
//Incluimos los Post Destacados
require 'includes/posts_destacados.php';
?>
</div>

<div id="recientes" style="display: flex;-webkit-flex: 1 1 100%;flex: 1 1 100%;flex-wrap: wrap;align-items: flex-start;">
<h2 style="margin-top:0;flex: 1 100%;background: #222;padding: 10px;color: #ddd;font-family: 'Roboto';font-size: 20px;">Recientes</h2>
<?php 
//Incluimos los Post
require 'includes/posts.php'; ?>
</div>
</div>

</div>
<?php
//Incluimos el Footer
require 'includes/footer.php';
?>
</div>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script src="<?php echo $dir.'/themes/'.$tema_select; ?>/js/main.js"></script>
<?php
if($G){
?>
<script src="<?php echo $dir.'/themes/'.$tema_select; ?>/js/main.php"></script>
<?php
}
?>
</body>
</html>
<?php
} else {
?>
<div>¡¡Error!! Has Modificado el Copyright del Footer</div>
<?php
}
?>