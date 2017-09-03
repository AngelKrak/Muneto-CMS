    <nav class="navbar navbar-inverse navbar-fixed-top">
      <i class="fa fa-bars menu2btn" style="display: block;float: left;color: #eee;padding: 16px 10px;font-size: 18px;cursor: pointer;"></i>
      <div class="menu2">
        <ul class="sidebarMenu">
          <li data-menuanchor="info" class="active"><a href="#info">Informacion</a></li>
          <li data-menuanchor="agregar" class="active"><a href="#agregar">Agregar Post</a></li>
          <li data-menuanchor="bd"><a href="#bd">Importar Base de Datos</a></li>
          <li data-menuanchor="configuracion"><a href="#configuracion">Configuracion</a></li>
          <li data-menuanchor="encriptador"><a href="#encriptador">Encriptador</a></li>
          <li data-menuanchor="cuenta"><a href="#cuenta">Cuenta</a></li>
          <li data-menuanchor="temas"><a href="#temas">Temas</a></li>
          <li data-menuanchor="trash"><a href="#trash">Post Eliminados</a></li>
          <li data-menuanchor="categoriass" class="active"><a href="#categoriass">Categorias</a></li>
          <li data-menuanchor="usuarioss" class="active"><a href="#usuarioss">Usuarios</a></li>
        </ul>
      </div>
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand logo" href="<?php echo "http://" . $host . $uri; ?>/../"><?php echo $titulo_web; ?></a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">Home</a></li>
            <li><a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&amp;hosted_button_id=JUREESC824Q3S" target="_blank">Donar</a></li>
            <li><a href="<?php echo "http://" . $host . $uri; ?>/../">Regresar</a></li>
          </ul>
        <div class="btn-group username">
  <a class="btn btn-primary" href="#"><i class="fa fa-user fa-fw"></i> <?php
        if($G){
        ?>
        <span class="usernamee"><?php echo $G; ?></span>
        <?php
        } else {
        ?>
        <span class="usernamee"><?php echo "Invitado"; ?></span>
        <?php
        }
        ?></a>
  <?php
    if($G){
  ?>
  <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#">
    <span class="fa fa-caret-down" title="Toggle dropdown menu"></span>
  </a>
  <ul class="dropdown-menu">
    <li><a href="#" title="PROXIMAMENTE!"><i class="fa fa-ban fa-fw"></i> Ver Perfil</a></li>
    <li class="divider"></li>
    <li><a href="php/salir.php?logout=0"><i class="fa fa-sign-out fa-fw"></i> Salir</a></li>
  </ul>
  <?php
    }else{
  ?>
  <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#">
    <span class="fa fa-caret-down" title="Toggle dropdown menu"></span>
  </a>
  <ul class="dropdown-menu">
    <li><a href="php/login.php" title="PROXIMAMENTE!"><i class="fa fa-sign-in fa-fw"></i> Iniciar Sesion</a></li>
  </ul>
  <?php
    }
  ?>
        </div><!--/.nav-collapse -->
      </div>
    </nav>