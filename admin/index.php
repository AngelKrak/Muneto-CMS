<?php
require '../php/config.php';
$usuariosURL = file_get_contents('php/usuarios.json');
$usuariosJSON = json_decode($usuariosURL);
session_start();

$G = eval('return '. $_SESSION['usuario']. ';');
$Correo = eval('return '. $_SESSION['correo']. ';');
$Contraseña = eval('return '. $_SESSION['contrasena']. ';');
$Rango = eval('return '. $_SESSION['rango']. ';');
$Imagen = eval('return '. $_SESSION['imagen']. ';');
$Nombre = eval('return '. $_SESSION['nombre']. ';');
$idAutor = eval('return '. $_SESSION['idAutor']. ';');
#$idAutor = $usuariosJSON->usuarios[$idAutor]->usuario;

/* NO MODIFICAR ESTA LINEA */
$versionGH = explode(':', file_get_contents('https://raw.githubusercontent.com/AngelKrak/MunetoVersion/master/version'));
$munetoV = trim($versionGH[1]); //Version Nueva de Muneto
$host  = $_SERVER['HTTP_HOST'];
$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
?>
<?php
if ($G == null) { //Si no inicio Sesion Redireccionamos al Login
  unset($_SESSION['usuario']);
  header("Location: php/login.php");
}
?>
<!doctype html>
<html lang="es-mx">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>Administracion de <?php echo $titulo_web; ?></title>
    <link href="http://fonts.googleapis.com/css?family=Montserrat:400normal,700normal|Open+Sans:400normal|Roboto:400normal|Raleway:400normal|Lato:400normal|Oswald:400normal|Lato:400normal|Source+Sans+Pro:400normal|Merriweather:400normal|Lora:400normal|Ubuntu:400normal&amp;subset=all" rel="stylesheet" type="text/css">
    <link href="http://getbootstrap.com/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.css">
    <link rel="stylesheet" type="text/css" href="https://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.13/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.1.1/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="../themes/<?php echo $tema_select; ?>/css/font-awesome-animation.css">
    <link rel="stylesheet" type="text/css" href="../themes/<?php echo $tema_select; ?>/css/jquery.fullPage.css" />
    <link rel="stylesheet" href="../themes/<?php echo $tema_select; ?>/css/style.css">
    <style type="text/css">
      body {
        padding-top: 25px !important;
      }
      .popover .popover-content img {
        width: 100%;
      }
    </style>
</head>
<body>
<?php include 'php/nav.php'; ?>
<div class="container">
<div class="template">
<?php
if($G) {
	//Inicie Sesion y muestro la Administracion
?>
<!-- Modal -->
  <div class="modal fade" id="Modal_Muneto" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Preview de <span class="modal_title_preview"></span></h4>
        </div>
        <div class="modal-body">
          <!-- Contenido del Textarea -->
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>

<!-- Modal para Editar Categoria -->
<div class="modal fade" id="editCategoria" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Editar Categoria</h4>
      </div>
      <div class="modal-body">
        <p>Introduce el Nuevo Nombre para la Categoria Seleccionada</p>

        <div id="EC_content" style="padding: 0;box-shadow: none;display: block;">
          <div class="Editar_Configg" style="padding: 0;">
            <input type="text" id="categoriaEditar" name="categoriaEditar" placeholder="Introduce el Nuevo Nombre de la Categoria" />
            <a href="#categoriass" class="faa-parent animated-hover">
              <i class="fa fa-pencil faa-pulse fa-fw" aria-hidden="true"></i>
              <input type="button" name="editarCategoria" id="editarCategoria" data-dismiss="modal" value="Editar" style="padding-left: 28px;" />
            </a>
          </div>
        </div>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div id="fullpage">
<div class="section" id="section0">
<div class="box">
<div class="texto_box">
  <h1>Informacion de Muneto</h1>
  <p>Aqui podras ver la Version que tienes de Muneto(Si hay Nueva Version), Posts Totales, Usuarios Registrados, Usuario con Sesion Iniciada</p>
</div>
<span class="box_mensaje info">
<div class="block flex">
<?php
  if ($version === $munetoV) {
    echo "<div class='version'>
<div class='flex'><div class='border left'>Version</div><div class='border' style='margin-left: -1px;'>$version</div></div>
<div class='border' style='display: block;margin-top: -1px;'>Tienes la Version mas Reciente de Muneto</div>
</div>";
  } else {
    echo "<div class='version'>
<div class='flex'><div class='border left'>Version</div><div class='border' style='margin-left: -1px;'>$version</div></div>
<div class='border' style='display: block;margin-top: -1px;'>Tienes la Version Antigua($version) de Muneto. <br />
Puedes Actualizar a la Nueva Version desde <a href='http://heroesdelaweb.com/tags/muneto-cms/'><strong>Aquí</strong></a></div>
</div>";
  }
?>
<?php
$usuarios = count($usuariosJSON->usuarios);
shuffle($usuariosJSON->usuarios); // Ordenamos los Usuarios en Aleatorio para Posteriormente Mostrarlos y que no sean los Mismos
echo "<div class='usuarios'>
<div class='flex'><div class='border left'>Usuarios Registrados</div><div class='border' style='margin-left: -1px;'>$usuarios Usuarios</div></div>";
echo "<div class='border' style='display: block;margin-top: -1px;'>";
for ($row = 0; $row < $usuarios; $row++) { //Contamos todos los Usuarios que tenemos Registrados
  if ($row < 5) { //Mostramos solo 5 Usuarios
    $u = $usuariosJSON->usuarios[$row]->usuario; //Mostramos los Usuarios en String
    $array[] = $u; //Los Convertimos a Array para posteriormente Unirlos
  }
}
echo join(', ', $array)."..."; //Los unimos separandolos con una coma y espacio, y al ultimo le agregamos Puntos Suspensivos
echo "</div>
</div>";
?>
<?php
function contador_post($dir) {
$post = file_get_contents(realpath($dir));
$getJSON = json_decode($post);
$contarIndicesJSON = count($getJSON->post);

return $contarIndicesJSON; //Contamos los Post que estan en el Array
}
echo "<div class='posts'>
<div class='flex'><div class='border left'>Post Publicados</div><div class='border' style='margin-left: -1px;'>".contador_post("../posts/posts.json")." Posts</div></div>
<div class='flex' style='margin-top: -1px;'><div class='border left' style='border: 1px solid #44a8ec;'>Post Eliminados</div><div class='border' style='flex:10;margin-left: -1px;'>".contador_post("../trash/trash.json")." Posts</div></div>
</div>"; //Mostramos el Numero de Posts contados
?>
</div>

<div class="block flex">
  <div class="myinfo">
  <img src="<?php echo $Imagen; ?>">
  <div class="myinfo2">
    <h1><?php echo $Nombre; ?></h1>
    <h3>@<?php echo $G; ?></h3>
    <h3 class="rango"><?php echo $Rango; ?></h3>
  </div>
  </div>
</div>
</span>
</div>
</div> <!-- Final section 0 fullpage jQuery -->

<?php
if($Rango == "Administrador" || $Rango == "Munetin") {
  //Inicie Sesion y muestro el Index
?>
<div class="section " id="section1">
<div id='agregarAlert'>
<div id='Agregarerror' class='alert alert-danger' role='alert' style="margin-top: 65px;margin-bottom: 10px;"></div>
<div id='Agregarsuccess' class='alert alert-success' role='alert' style="margin-top: 65px;margin-bottom: 10px;">El Post ha sido Creado</div>
</div>
<form method="post" id="agregar_form">
   <input type="text" name="img_autor" id="img_autor" value="<?php if(@$G){echo $Imagen;}else{echo '../img/no_img.png';}?>" required style="display: none;" />
   <input type="text" name="titulo" id="titulo_form" placeholder="Introduce el Titulo" required />
   <input type="text" name="descripcion" id="descripcion_form" placeholder="Introduce la Descripcion" maxlength="255" required />
   <input type="text" name="imagen" id="imagen_form" placeholder="Introduce el Url de la Imagen" required />
   <input type="text" name="autor" id="autor_form" placeholder="Autor del Post" value="<?php if(@$G){ echo $idAutor;}?>" required />
   <input type="text" name="fecha" id="fecha_form" required />
   <input type="text" name="DataDia" id="FechaDataDia" value="" required style="display:none;"/>
   <input type="text" name="DataMes" id="FechaDataMes" value="" required style="display:none;"/>
   <div class="hora_cont">
   <input type="text" name="hora" id="hour_form" required />
   <div id="hora_stop" style="position: absolute;right: 20px;top: 10px;"><i class="fa fa-play fa-fw" aria-hidden="true" title="Iniciar Hora" style="margin: auto 5px;"></i><i class="fa fa-pause fa-fw" title="Pausar Hora" aria-hidden="true"></i></div>
   </div>
   <div id="html_editor">
   <textarea name="contenido" rows="5" placeholder="Escribe el Contenido" id="contenido_form" required></textarea>
   </div>
   <div id="tags_cat">
   <?php
    require 'php/categorias.php';
    asort($categorias);
    $contarCat = count($categorias);
   ?>
   <select name="categoria" class="form-control categorias <?php if ($contarCat == 0){echo "none";} ?>" id="categorias" required>
   <?php
   if ($contarCat == 0) {
    echo '<option value="" selected>No Hay Categorias</option>';
   }
   foreach ($categorias as $categoria) {
     echo '<option value="'.$categoria.'">'.$categoria.'</option>';
   }
   ?>
   </select>
   <input id="tags" type="text" name="tags" placeholder="Introduce Minimo 3 Tags" data-role="tagsinput" style="flex:1 100%;"/>
   </div>

   <button type="submit" name="enviar" class="btn enviar">
    <a href="#agregar" class="faa-parent animated-hover no-link">
      <i class="fa fa-plus faa-pulse fa-fw" aria-hidden="true"></i> Agregar
    </a>
   </button>
   <!--<input type="submit" name="preview" class="preview" value="Previsualizar" />-->
   <button type="button" name="preview" class="btn preview">
    <a href="#agregar" class="faa-parent animated-hover no-link">
       <i class="fa fa-eye faa-pulse fa-fw" aria-hidden="true"></i> Previsualizar
    </a>
   </button>
</form>
</div> <!-- Final section 1 fullpage jQuery -->
<?php
}else{
  echo '<div class="section" id="section1">
';
  echo "Lo Sentimos, no cuenta con los Permisos Suficientes para Agregar un Post
";
  echo "</div>
";
}
?>

<?php
if($Rango == "Administrador"){
  //Inicie Sesion y muestro el Index
?>
<div class="section" id="section2">
<div id="db_content">
<div class="texto_db">
  <h1>Gestionar Base de Datos</h1>
  <p>Ahora ya puedes Subir/Ver/Eliminar/Gestionar Bases de Datos.</p>
</div>
<div id="Base_de_Datos">
  <div id="tabsDB">
    <div class="tabBTNDB active" data-option="upload" style="border-radius: 3px 0 0 0">Subir Base de Datos</div>
    <div class="tabBTNDB" data-option="verDB" style="border-radius: 0 3px 0 0">Ver Base's de Datos</div>
    <div class="tabBTNDB" data-option="gestionarDB" style="border-radius: 0 3px 0 0">Gestionar Base de Datos</div>
  </div>

  <div id="contentDB">
    <div class="tabContentDB active" data-option="upload">
      <input type="file" name="db" accept=".json">
    </div>
    <div class="tabContentDB" data-option="verDB">
      <div class="contentDB">
      <?php
        $dirDB = str_ireplace('\\', '/', dirname(__FILE__) . '/../bases_de_datos/');
        $dirDBOpen = opendir($dirDB);
        while ($dbs = readdir($dirDBOpen)) {
          if (substr($dbs, -4) == "json") {
            $getPosts = file_get_contents($dirDB.$dbs);
            $dbJSON = json_decode($getPosts);
            $contarPostsDB = count($dbJSON->post);
            
            echo '<div class="dbC">
            <div class="dbIcon"><i class="fa fa-database fa-fw" aria-hidden="true"></i></div>
            <div class="posts_nameDB">
              <span class="dbNombre">'.$dbs.'</span>
              <span class="dbposts">'.$contarPostsDB.' Posts</span>
            </div>
            <div class="dbBTN">
              <div class="btnDB btn-primary gestionarDB" data-dbruta="'.$dirDB.$dbs.'"><i class="fa fa-edit fa-fw" aria-hidden="true"></i> Gestionar</div>
              <div class="btnDB btn-danger eliminarDB" data-dbruta="'.$dirDB.$dbs.'"><i class="fa fa-times fa-fw" aria-hidden="true"></i> Eliminar</div>
            </div>
            </div>';
            echo "\n";
          }
        }
      ?>
      </div>
    </div>
    <div class="tabContentDB" data-option="gestionarDB">
      <div class="alert alert-warning fade in" style="display: block;">Necesitas Primero Seleccionar una Base de Datos!</div>
    </div>
  </div>
</div>
</div>
</div> <!-- Final section 2 fullpage jQuery -->
<?php
}else{
  echo '<div class="section" id="section2">
';
  echo "Lo Sentimos, no cuenta con los Permisos Suficientes para Administrar las Bases de Datos
";
  echo "</div>
";
}
?>
<?php
if($Rango == "Administrador"){
?>
<div class="section" id="section3">
<div id='EC_mensaje'>
<div id='error' class='alert alert-danger' role='alert'></div>
</div>
<div id="EC_content">
<div class="texto_db">
  <h1>Configuracion de la Pagina</h1>
  <p>Puedes configurar la Pagina Web desde la Administracion, asi como el Titulo de la Web, El Slogan.</p>
</div>
<form method="post" id="editar_config" class="editarConfig" action="../php/edit_config.php">
  <div class="Editar_Titulo_Web Editar_Configg">
  <label class="editar_label">Titulo de la Web</label>
  <input type="text" name="titulo_web" id="titulo_web" placeholder="Titulo de la Web" value="<?php echo $titulo_web; ?>" />
  <a href="#" class="faa-parent animated-hover">
    <i class="fa fa-pencil faa-pulse fa-fw" aria-hidden="true"></i>
    <input type="submit" name="editar_titulo_web" value="Editar" />
  </a>
  </div>

  <div class="Editar_Slogan Editar_Configg">
  <label class="editar_label">Slogan de la Web</label>
  <input type="text" name="slogan" id="slogan" placeholder="Slogan de la Web" value="<?php echo $slogan; ?>" />
  <a href="#" class="faa-parent animated-hover">
    <i class="fa fa-pencil faa-pulse fa-fw" aria-hidden="true"></i>
    <input type="submit" name="editar_slogan" value="Editar" />
  </a>
  </div>

  <!-- Editamos todos los Campos con este Boton -->
  <div class="left-inner-addon all_config">
    <i class="icon-user"></i>
    <input type="submit" name="editar_config" class="editar_config" value="Editar Todos los Campos" />
  </div>
  
</form>
</div>
</div> <!-- Final section 3 fullpage jQuery -->
<?php
}else{
  echo '<div class="section" id="section3">
';
  echo "Lo Sentimos, no cuenta con los Permisos Suficientes para Cambiar la Configuracion de $titulo_web
";
  echo "</div>
";
}
?>

<div class="section" id="section4">
<div id="encriptar_content">
<div class="texto_encriptar">
  <h1>Encriptador de Contraseñas</h1>
  <p>Introduce algun Texto y te los Mostrara ya Encriptado en Password HASH.</p>
</div>
<span id="encriptar_mensaje"><a href="#" class="faa-parent animated-hover"><i class="fa fa-key faa-pulse fa-fw" aria-hidden="true"></i></a> <span>No has Encriptado ninguna Contraseña</span></span>
<div id="Encriptar_Password">
<form id="encriptar">
<input type="text" id="hash" name="hash" placeholder="Introduce el Texto a Encriptar" />
</form>
</div>
</div>
</div> <!-- Final section 4 fullpage jQuery -->

<div class="section" id="section5">
<div id='EC_mensaje'>
<div id='error' class='alert alert-danger' role='alert'></div>
</div>
<div id="EC_content">
<div class="texto_db">
  <h1>Editar Cuenta</h1>
  <p>Edita los Datos de tu Cuenta Individualmente o en Conjunto con las Opciones de Editar.</p>
</div>
<form method="post" id="editar_config" class="editarConfig" action="php/editar_cuenta.php" >

  <div id="tabs1" class="tabPanel">
    <div class="tabBTN active" data-option="showDats" >Datos</div>
    <div class="tabBTN" data-option="updatePass" >Contraseña</div>
    <div class="tabBTN" data-option="updateAvatar" >Avatar</div>
  </div>

  <div id="tabsContentCuenta" class="tabsContentCuenta">
    <div class="tabContent active" data-option="showDats">   
        <div class="Editar_Configg">
          <label class="editar_label">Nombre</label>
          <input type="text" id="cuenta_nombre" name="cuenta_nombre" placeholder="Introduce el Texto a Encriptar" value="<?php echo $Nombre; ?>" />
          <a href="#" class="faa-parent animated-hover">
            <i class="fa fa-pencil faa-pulse fa-fw" aria-hidden="true"></i>
            <input type="submit" name="editar_nombre" value="Editar" />
          </a>
        </div>

        <div class="Editar_Configg">
          <label class="editar_label">Nombre de Usuario</label>
          <input type="text" id="cuenta_usuario" name="cuenta_usuario" placeholder="Introduce el Texto a Encriptar" value="<?php echo $G; ?>" />
          <a href="#" class="faa-parent animated-hover">
            <i class="fa fa-pencil faa-pulse fa-fw" aria-hidden="true"></i>
            <input type="submit" name="editar_usuario" value="Editar" />
          </a>
        </div>

        <div class="Editar_Configg">
          <label class="editar_label">Correo Electronico</label>
          <input type="text" id="cuenta_correo" name="cuenta_correo" placeholder="Introduce el Texto a Encriptar" value="<?php echo $Correo; ?>" />
          <a href="#" class="faa-parent animated-hover">
            <i class="fa fa-pencil faa-pulse fa-fw" aria-hidden="true"></i>
            <input type="submit" name="editar_correo" value="Editar" />
          </a>
        </div>

        <div class="Editar_Configg">
          <label class="editar_label">Rango</label>
          <?php
         if ($Rango == "Administrador") {
         ?>
          <input type="text" id="cuenta_rango" name="cuenta_rango" placeholder="Introduce el Texto a Encriptar" value="<?php echo $Rango; ?>" />
          <a href="#" class="faa-parent animated-hover">
            <i class="fa fa-pencil faa-pulse fa-fw" aria-hidden="true"></i>
            <input type="submit" name="editar_rango" value="Editar" />
          </a>
          <?php
         } else {
         ?>
          <input type="text" id="cuenta_rango" placeholder="Introduce el Texto a Encriptar" value="<?php echo $Rango; ?>" style="border-radius: 4px;" readonly />
          <?php
         }
         ?>
        </div>
    </div>

    <div class="tabContent" data-option="updatePass">   
      <div class="Editar_Configg">
        <label class="editar_label">Contraseña Antigua</label>
        <input type="password" id="pass_old" name="pass_old" placeholder="Introduce la Contraseña Antigua" style="border-radius: 4px;" />
      </div>

      <div class="Editar_Configg">
          <label class="editar_label">Contraseña Nueva</label>
          <input type="password" id="pass_new" name="pass_new" placeholder="Introduce la Contraseña Nueva" />
          <a href="#" class="faa-parent animated-hover">
            <i class="fa fa-pencil faa-pulse fa-fw" aria-hidden="true"></i>
            <input type="submit" name="pass_new" value="Editar" />
          </a>
      </div>
    </div>

    <div class="tabContent" data-option="updateAvatar">   
      <div class="Editar_Configg">
        <label class="editar_label">Imagen</label>
        <a href="#" class="preview_config" data-toggle="popover" title="Preview de la Imagen" data-img="<?php echo $Imagen; ?>"><input type="text" id="cuenta_imagen" name="cuenta_imagen" placeholder="Introduce el Texto a Encriptar" value="<?php echo $Imagen; ?>" /></a>
        <a href="#" class="faa-parent animated-hover">
          <i class="fa fa-pencil faa-pulse fa-fw" aria-hidden="true"></i>
          <input type="submit" name="editar_imagen" value="Editar" />
        </a>
      </div>
    </div>
  </div> 
</form>
</div>
</div> <!-- Final section 5 fullpage jQuery -->

<?php
if (isset($_SESSION['error'])) { //Mostramos el Error si la Sesion Error ha sido Enviada
  unset($_SESSION['error']); //Eliminamos la Sesion una vez mostrado el Error
?>
<div class="section" id="section6">
<div id="encriptar_content">
<span id="encriptar_mensaje"><a href="#" class="faa-parent animated-hover"><i class="fa fa-warning faa-pulse fa-fw" aria-hidden="true"></i></a> <span>Hubo un Error al Editar la Configuracion, <a href="#cuenta">Volver a la Configuracion</a></span></span>
</div>
</div> <!-- Final section 6 fullpage jQuery -->
<?php
}
?>

<?php
if($Rango == "Administrador") {
?>
<div class="section" id="section7">
<div id="encriptar_content" style="text-align: left;">
<div class="texto_encriptar">
  <h1>Selecciona un Tema</h1>
</div>
<div class="tema_actual"><strong class="ruta">Ruta del Tema Actual:</strong> <span class="ruta"><?php
require '../php/config.php';
$host  = $_SERVER['HTTP_HOST'];
$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$base = "http://" . $host . $uri . "/";
$a = str_replace("administrador", "themes", $base);
echo $a.$tema_select; ?></span>
</div>
<div id="Themes_Management">
<?php
require 'php/themes.php';
  echo listar_carpetas("../themes");
?>
</div>
</div>
</div>
<?php
}else{
  echo '<div class="section" id="section7">
';
  echo "Lo Sentimos, no cuenta con los Permisos Suficientes para Cambiar el Tema de $titulo_web
";
  echo "</div>
";
}
?> <!-- Final section 7 fullpage jQuery -->

<?php
if($Rango == "Administrador") {
?>
<div class="section" id="section8">
<div id="encriptar_content" style="text-align: left;">
<div class="texto_encriptar">
  <h1 style="font-size: 3em;">Publica o Elimina los Post de la Papelera</h1>
</div>
<div class="box_mensaje mensj">
<span class="alert" style="width: 100%;"></span>
</div>
<div id="Themes_Management" class="postsTrash">
<?php include '../includes/posts_trash.php'; ?>
</div>
</div>
</div>
<?php
}else{
  echo '<div class="section" id="section8">
';
  echo "Lo Sentimos, no cuenta con los Permisos Suficientes para Ver los Posts Eliminados de $titulo_web
";
  echo "</div>
";
}
?> <!-- Final section 8 fullpage jQuery -->

<?php
if($Rango == "Administrador") {
?>
<div class="section" id="section9">
<div id="encriptar_content" style="text-align: left;">
<div id='EC_mensaje'>
  <div id='categoriasAlert' class="alertOff"></div>
</div>

<div class="texto_encriptar">
  <h1 style="font-size: 2.5em;">Administrar Categorias</h1>
</div>
<div id="Themes_Management" class="categoriasContent">
  <div id="tabs">
    <div class="tabBTN active" data-option="verCategoria" style="border-radius: 3px 0 0 0">Ver Categorias</div>
    <div class="tabBTN" data-option="agregarCategoria" style="border-radius: 0 3px 0 0">Agregar Categorias</div>
  </div>

  <div id="tabsContent">
    <div class="tabContent active" data-option="verCategoria">
      <?php
        require 'php/categorias.php';
        asort($categorias);
        $contarCat = count($categorias);
        if ($contarCat == 0) {
          echo "<div id='success' class='alert alert-danger' role='alert' style='display: block;padding: 15px;margin: 10px 5px;'>No Hay Categorias</div>";
        } else {
      ?>
      <div class="table-responsive" style="margin: 10px;">
        <table name="categoria" class="table <?php if ($contarCat == 0){echo "none";} ?> table-striped table-bordered" cellspacing="0" width="100%" id="categorias">
          <thead>
            <tr>
              <th style="font-weight: bold;font-size: 1.1em;width: 1px;">#</th>
              <th style="font-weight: bold;font-size: 1.1em">Categoria</th>
              <th style="font-weight: bold;font-size: 1.1em;width: 1px;">Editar/Eliminar</th>
            </tr>
          </thead>
          <tbody>
            <?php
              foreach ($categorias as $categoriaNum => $categoria) {
                echo '<tr data-num="'.$categoriaNum.'" data-categorianame="'.$categoria.'">
                <td data-num="'.$categoriaNum.'">'.$categoriaNum.'</td>
                <td data-categorianame="'.$categoria.'">'.$categoria.'</td>
                <td><a href="#categoriass" data-toggle="modal" data-target="#editCategoria" data-categorianame="'.$categoria.'" style="padding-right: 10px;"><i class="fa fa-pencil" aria-hidden="true" style="font-size: 1.2em;"></i></a> <a href="#categoriass" class="delCategoria" data-categorianame="'.$categoria.'" style="padding-right: 10px;"><i class="fa fa-trash" aria-hidden="true" style="font-size: 1.2em;"></i></a></td>
                </tr>';
              }
            ?>
          </tbody>
        </table>
      </div>
      <?php } ?>
    </div>
    <div class="tabContent" id="EC_content" data-option="agregarCategoria" style="padding: 0;box-shadow: none;">
      <form method="post" id="nuevaCategoria" class="nuevaCategoria">
        <div class="Editar_Configg" style="padding: 0 10px;">
          <label class="editar_label" style="padding: 6px;">Agregar Categoria Nueva</label>
          <input type="text" id="categoriaNueva" name="categoriaNueva" placeholder="Introduce el Nombre de la Categoria" />
          <a href="#categoriass" class="faa-parent animated-hover">
            <i class="fa fa-pencil faa-pulse fa-fw" aria-hidden="true"></i>
            <input type="button" id="agregarCategoria" name="agregarCategoria" value="Agregar" style="padding-left: 28px;" />
          </a>
        </div>
      </form>
    </div>
  </div>
</div>
</div>
</div>
<?php
}else{
  echo '<div class="section" id="section9">
';
  echo "Lo Sentimos, no cuenta con los Permisos Suficientes para Ver/Modificar/Eliminar las Categorias de $titulo_web
";
  echo "</div>
";
}
?> <!-- Final section 9 fullpage jQuery -->

<?php
if($Rango == "Administrador") {
?>
<div class="section" id="section10">
<div id="encriptar_content" style="text-align: left;">
<div id='EC_mensaje'>
  <div id='usuariosAlert' class="alertOff"></div>
</div>

<div class="texto_encriptar">
  <h1 style="font-size: 2.5em;">Administrar Usuarios</h1>
</div>
<div id="Themes_Management" class="usuariosContent">
  <div id="tabs2">
    <div class="tabBTN active" data-option="verUsuario" style="border-radius: 3px 0 0 0">Ver Usuarios</div>
    <div class="tabBTN" data-option="agregarUsuario" style="border-radius: 0 3px 0 0">Agregar Usuario</div>
  </div>

  <div id="tabsContent2">
    <div class="tabContent active" data-option="verUsuario">
      <?php
      asort($usuariosJSON->usuarios);
        $contarUser = count($usuariosJSON->usuarios);
        if ($contarUser == 0) {
          echo "<div id='success' class='alert alert-danger' role='alert' style='display: block;padding: 15px;margin: 10px 5px;'>No Hay Usuarios</div>";
        } else {
      ?>
      <div class="table-responsive dos" style="margin: 10px;overflow: visible;">
        <table name="usuario" class="display responsive no-wrap table <?php if ($contarCat == 0){echo "none";} ?> table-striped table-bordered" cellspacing="0" width="100%" id="usuarios">
          <thead>
            <tr>
              <th style="font-weight: bold;font-size: 1.1em;width: 1px;">#</th>
              <th style="font-weight: bold;font-size: 1.1em">Nombre</th>
              <th style="font-weight: bold;font-size: 1.1em">Usuario</th>
              <th style="font-weight: bold;font-size: 1.1em">Rango</th>
              <th style="font-weight: bold;font-size: 1.1em">Correo Electronico</th>
              <th style="font-weight: bold;font-size: 1.1em">Imagen</th>
              <th style="font-weight: bold;font-size: 1.1em;width: 1px;">Editar/Eliminar</th>
            </tr>
          </thead>
          <tbody>
            <?php
              foreach ($usuariosJSON->usuarios as $usuario) {
                echo '<tr data-num="'.$usuario->id.'" data-usuarioname="'.$usuario->datos_personales->nombre.'">
                <td data-num="'.$usuario->id.'">'.$usuario->id.'</td>
                <td>'.$usuario->datos_personales->nombre.'</td>
                <td>@'.$usuario->usuario.'</td>
                <td>'.$usuario->rango.'</td>
                <td>'.$usuario->datos_personales->email.'</td>
                <td><a href="'.$usuario->datos_personales->imagen_perfil.'" class="preview_config" data-toggle="popover" title="Preview de la Imagen" data-img="'.$usuario->datos_personales->imagen_perfil.'" target="_blank">Abrir Imagen</a></td>
                <td><a href="#usuarioss" data-toggle="modal" data-target="#" style="padding-right: 10px;"><i class="fa fa-ban" aria-hidden="true" style="font-size: 1.2em;"></i></a> <a href="#usuarioss" class="delUsuario" data-usuarioname="'.$usuario->datos_personales->nombre.'" style="padding-right: 10px;"><i class="fa fa-ban" aria-hidden="true" style="font-size: 1.2em;"></i></a></td>
            </tr>
            ';
              }
            ?>
          </tbody>
        </table>
      </div>
      <?php } ?>
    </div>
    <div class="tabContent" id="EC_content" data-option="agregarUsuario" style="padding: 0;box-shadow: none;">
      <form method="post" id="nuevaCategoria" class="nuevaCategoria">
        <div class="Editar_Configg" style="padding: 0 10px;">
          <label class="editar_label" style="padding: 6px;">Agregar Usuario Nuevo</label>
          <input type="text" id="categoriaNueva" name="categoriaNueva" placeholder="Introduce el Nombre del Nuevo Usuario" />
          <a href="#categoriass" class="faa-parent animated-hover">
            <i class="fa fa-pencil faa-pulse fa-fw" aria-hidden="true"></i>
            <input type="button" id="agregarUsuario" name="agregarUsuario" value="Agregar" style="padding-left: 28px;" />
          </a>
        </div>
      </form>
    </div>
  </div>
</div>
</div>
</div>
<?php
}else{
  echo '<div class="section" id="section10">
';
  echo "Lo Sentimos, no cuenta con los Permisos Suficientes para Ver/Modificar/Eliminar las Categorias de $titulo_web
";
  echo "</div>
";
}
?> <!-- Final section 10 fullpage jQuery -->

</div> <!-- Final fullpage jQuery(plugin) -->
<?php
}
?>
</div> <!-- Final de la Clase(div) Template -->
</div> <!-- Final de la Clase(div) Container -->

<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
<script src="http://getbootstrap.com/dist/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>
<script src="https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
<script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>
<script src="../tinymce/tinymce.min.js"></script>
<script type="text/javascript" src="../themes/<?php echo $tema_select; ?>/js/jquery.fullPage.js"></script>
<script type="text/javascript" src="../themes/<?php echo $tema_select; ?>/js/examples.js"></script>
<script type="text/javascript">
document.querySelector(".preview_config, .no-link").addEventListener("click", function(event){
    event.preventDefault();
});

  $(document).ready(function() {
    $('#fullpage').fullpage({
      anchors: ['info', 'agregar', 'bd', 'configuracion', 'encriptador', 'cuenta', <?php if (isset($_SESSION['error'])) { echo "'error',"; } ?> 'temas', 'trash', 'categoriass', 'usuarioss'],
      menu: '#menu',
      keyboardScrolling: false,
      lazyLoading: true,
      scrollingSpeed: 0,
      responsiveWidth: 620
    });
  });
</script>

<script src="js/index.js"></script>
<script src="js/index.php"></script>
</body>
</html>