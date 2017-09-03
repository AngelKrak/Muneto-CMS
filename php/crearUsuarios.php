<?php
require 'php/config.php';
require 'includes/copy.php';

if ($Copyright == '<a href="https://facebook.com/angelkrak92" target="_blank"><b>Angel Komander</b></a>') {
?>
<!DOCTYPE html>
<html >
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no">
    <title><?php echo $titulo_web; ?> | <?php echo $slogan; ?></title>
    <meta name="description" content="Muneto es un Pequeño CMS que esta en Version Alpha hecho con PHP y AJAX sin MYSQL(Base de Datos)">
    <!-- Bootstrap core CSS -->
    <link href="http://getbootstrap.com/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Slabo+27px" rel="stylesheet">
    <link rel="stylesheet" href="themes/<?php echo $tema_select; ?>/css/style.css">
  </head>

  <body>
<div class="container">
	<div class="template">
		<noscript>
		  <h2>Lo Siento! Tu navegador no Soporta o no Tiene Activado Javascript.</h2>
		</noscript>
		<div id='mensajes'></div>

		<div class="usuariosAdmin">
			<h4 style="border-bottom: 1px solid #ddd;padding-bottom: 10px;">¿Deseas Crear un Usuario para la Administracion o Mantener los Usuarios por Defecto?</h4>
			<form id="usuariosAdminForm">
				<div class="usuariosAdminDiv">
					<label for="nombreNewUser">Nombres</label>
					<input type="text" name="Nombres" id="nombreNewUser">
				</div>
				<div class="usuariosAdminDiv">
					<label for="emailNewUser">Correo Electronico</label>
					<input type="text" name="email" id="emailNewUser">
				</div>
				<div class="usuariosAdminDiv">
					<label for="usuarioNewUser">Nombre de Usuario</label>
					<input type="text" name="NombredeUsuario" id="usuarioNewUser">
				</div>
				<div class="usuariosAdminDiv">
					<label for="imagenNewUser">Imagen</label>
					<input type="text" name="imagen" id="imagenNewUser">
				</div>
				<div class="usuariosAdminDiv">
					<label for="contrasenaNewUser">Contraseña</label>
					<input type="password" name="Contrasena" id="contrasenaNewUser">
				</div>

			</form>
			<div class="flex">
				<button type="button" class="button crearUsuario" style="display: none;" data-metodo="usuarioNew">Crear Usuario</button>
				<button type="button" class="button crearUsuarioAdmin">Crear un Usuario Nuevo</button>
				<button type="button" class="button mantenerUsuarioAdmin" data-metodo="mantenerUsuarios">Mantener los Usuarios por Defecto</button>
			</div>
		</div>
	</div>
</div>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
<script type="text/javascript">
$(".crearUsuarioAdmin").click(function() {
  $("#usuariosAdminForm").animate({
    height: [ "toggle", "swing" ]
  }, 500, "linear", function() {
    $(".flex .button").hide(500, function() {
    	$(".flex .crearUsuario").css({
    		margin: '20px 0',
    		maxWidth: '320px'
    	}).show(200);
    });
  });
});

$(".flex .crearUsuario").click(function() {
	var nombres = $("#nombreNewUser");
	var email = $("#emailNewUser");
	var usuario = $("#usuarioNewUser");
	var imagen = $("#imagenNewUser");
	var contrasena = $("#contrasenaNewUser");
	var metodo = $(this).data('metodo');
	var serializee = $("#usuariosAdminForm").serialize();

	if (nombres.val().trim() == '') {
		$("#mensajes").slideDown(200, function() {
			$("#mensajes").html("<div id='error' class='alert alert-danger' role='alert'>El Campo de <strong>Nombres</strong> no puede Estar Vacio</div>");
			$("#error").slideDown(500).delay(5000).slideUp(500);
			nombres.focus();
		});

		return false;
	} else if (email.val().trim() == '') {
		$("#mensajes").slideDown(200, function() {
			$("#mensajes").html("<div id='error' class='alert alert-danger' role='alert'>El Campo de <strong>Email</strong> no puede Estar Vacio</div>");
			$("#error").slideDown(500).delay(5000).slideUp(500);
			email.focus();
		});

		return false;
	} else if (usuario.val().trim() == '') {
		$("#mensajes").slideDown(200, function() {
			$("#mensajes").html("<div id='error' class='alert alert-danger' role='alert'>El Campo de <strong>Nombre de Usuario</strong> no puede Estar Vacio</div>");
			$("#error").slideDown(500).delay(5000).slideUp(500);
			usuario.focus();
		});

		return false;
	} else if (imagen.val().trim() == '') {
		$("#mensajes").slideDown(200, function() {
			$("#mensajes").html("<div id='error' class='alert alert-danger' role='alert'>El Campo de <strong>Imagen</strong> no puede Estar Vacio</div>");
			$("#error").slideDown(500).delay(5000).slideUp(500);
			imagen.focus();
		});

		return false;
	} else if (contrasena.val().trim() == '') {
		$("#mensajes").slideDown(200, function() {
			$("#mensajes").html("<div id='error' class='alert alert-danger' role='alert'>El Campo de <strong>Contraseña</strong> no puede Estar Vacio</div>");
			$("#error").slideDown(500).delay(5000).slideUp(500);
			contrasena.focus();
		});

		return false;
	}

	$.post("php/crearUsuario.php", serializee+"&usuario="+usuario.val()+"&crearUsuario="+usuario.val()+"&metodo="+metodo, function(data){
    $("#mensajes").slideDown(200, function() {
			$("#mensajes").html(data.mensaje);
			$("#error").slideDown(500).delay(5000).slideUp(500);
		});
  },"json");
});

$(".flex .mantenerUsuarioAdmin").click(function() {
	var usuario = $("#usuarioNewUser");
	var metodo = $(this).data('metodo');

	$.post("php/crearUsuario.php", "crearUsuario="+usuario.val()+"&metodo="+metodo, function(data) {
    $("#mensajes").slideDown(200, function() {
			$("#mensajes").html(data.mensaje);
			$("#error").slideDown(500).delay(5000).slideUp(500);
		});
  },"json");
});
</script>
</body>
</html>
<?php
}
?>