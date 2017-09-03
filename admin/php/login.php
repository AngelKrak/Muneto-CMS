<?php
require '../../php/config.php';
?>
<?php
session_start();
if (isset($_SESSION['usuario'])) {
  header("Location: ../index.php");
} else {
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, user-scalable=no">
  <title>Iniciar Sesion | <?php echo $titulo_web; ?></title>
  <link href="http://getbootstrap.com/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="http://fontawesome.io/assets/font-awesome/css/font-awesome.css">
  <link type="text/css" rel="stylesheet" href="../css/style.css">
  <link href="https://fonts.googleapis.com/css?family=Concert+One|Lato|Merienda+One" rel="stylesheet">
</head>
<body>
<div id="mensajes">
  <div id="alr" style="transform: translateX(-100%);transition: all 1s ease-in;z-index: 99999;"></div>
</div>

<div class="centerFlex">
	<div class="login">
		<div class="headerLogin">
			<div class="fondo"></div>
			<div class="topHeader">
				<i class="fa fa-globe fa-fw icono"></i>
				<h2 class="titulo">Login | <?php echo $titulo_web; ?></h2>
				<p>Este Login fue Creado por AngelKrak</p>
			</div>
			<div class="bottomHeader">
				<div class="listButton crearCuenta"><i class="fa fa-circle-thin" aria-hidden="true" style="padding-right: 5px;"></i> Crear Cuenta</div>
				<div class="listButton back"><a href="javascript:history.back(1)"><i class="fa fa-circle-thin" aria-hidden="true" style="padding-right: 5px;"></i> Regresar</a></div>
			</div>
		</div>
	  <form id="log-cont" method="post">
	  	<div id="inicio">
		    <div class="user-conte inputGroup">
		    	<p class="labelText">Usuario/Correo</p>
		    	<div class="inputIcon">
			      <span class="spanIcon"><i class="fa fa-envelope-o icon"></i></span>
			      <input type="text" id="username" name="nick" placeholder="Username or e-mail" required="required" />
		      </div>
		    </div>
		    <div class="pass-conte inputGroup">
		    	<p class="labelText">Contraseña</p>
			    <div class="inputIcon">
			      <span class="spanIcon"><i class="fa fa-key icon"></i></span>
			      <input type="password" id="password" name="pass" placeholder="Password" required="required" />
			    </div>
		    </div>
		    <button type="button" name="sub" class="submit login">Iniciar Sesion</button>
		  </div>
		  <div id="registro">
		  	<div class="user-conte inputGroup">
		    	<p class="labelText">Nombre</p>
		    	<div class="inputIcon">
			      <span class="spanIcon"><i class="fa fa-globe icon"></i></span>
			      <input type="text" id="name" name="nameR" placeholder="Name" required="required" />
		      </div>
		    </div>
		    <div class="user-conte inputGroup">
		    	<p class="labelText">Usuario</p>
		    	<div class="inputIcon">
			      <span class="spanIcon"><i class="fa fa-user icon"></i></span>
			      <input type="text" id="username" name="nickR" placeholder="Username" required="required" />
		      </div>
		    </div>
		    <div class="user-conte inputGroup">
		    	<p class="labelText">Correo Electronico</p>
		    	<div class="inputIcon">
			      <span class="spanIcon"><i class="fa fa-envelope-o icon"></i></span>
			      <input type="text" id="email" name="emailR" placeholder="E-mail" required="required" />
		      </div>
		    </div>
		    <div class="pass-conte inputGroup">
		    	<p class="labelText">Contraseña</p>
			    <div class="inputIcon">
			      <span class="spanIcon"><i class="fa fa-key icon"></i></span>
			      <input type="password" id="password" name="passR" placeholder="Password" required="required" />
			    </div>
		    </div>
		    <div class="pass-conte inputGroup">
		    	<p class="labelText">Imagen</p>
			    <div class="inputIcon">
			      <span class="spanIcon"><i class="fa fa-image icon"></i></span>
			      <input type="text" id="image" name="imageR" placeholder="Image" required="required" />
			    </div>
		    </div>
		    <button type="button" name="sub" class="submit register">Registrarse</button>
		  </div>
	  </form>
	</div>
</div>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
<script src="http://getbootstrap.com/dist/js/bootstrap.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$(".listButton").hover(function() {
		$(this).find('.fa').removeClass('fa-circle-thin');
		$(this).find('.fa').addClass('fa-circle');
	}, function() {
		$(this).find('.fa').removeClass('fa-circle');
		$(this).find('.fa').addClass('fa-circle-thin');
	});

	var register = false;
	$(".listButton").not(".back").click(function(e) {
		e.stopPropagation();
		e.preventDefault();

		if (register == true) {
			register = false;
			$(".listButton.iniciarSesion").html('<i class="fa fa-circle-thin" aria-hidden="true" style="padding-right: 5px;"></i> Crear Cuenta').removeClass('iniciarSesion').addClass('crearCuenta');
			$("#log-cont #inicio").delay(600).show(0);
			$("#log-cont #registro").css('transform', 'translateY(-150%)').delay(500).hide(0);
			setTimeout(function() {
				$("#log-cont #inicio").css('transform', 'translateY(0)');
			}, 650);
		} else {
			register = true;
			$(".listButton.crearCuenta").html('<i class="fa fa-circle-thin" aria-hidden="true" style="padding-right: 5px;"></i> Iniciar Sesion').removeClass('crearCuenta').addClass('iniciarSesion');
			$("#log-cont #registro").delay(600).show(0);
			$("#log-cont #inicio").css('transform', 'translateY(-150%)').delay(500).hide(0);
			setTimeout(function() {
				$("#log-cont #registro").css('transform', 'translateY(0)');
			}, 650);
		}
	});

  $("#log-cont .submit.login").click(function(e) {
    var nick = $("#log-cont #inicio #username").val();
    var pass = $("#log-cont #inicio #password").val();

    $.ajax({
      type: "POST",
      url: "procesar.php",
      data: "nick="+nick+"&pass="+pass,
      success: function(done) {
        document.querySelector("#alr").innerHTML = done;
        $("#alr").css({
          "transform": "translate(0)",
          "left": "10px"
        });

        if ($("#alr .alert").hasClass('valido')) {
          setTimeout(function() {
            location.reload();
          }, 3000);
        }
      }
    }); //Terminamos la Funcion Ajax
  });

  $("#log-cont .submit.register").click(function(e) {
  	var form = $("#log-cont").serialize();

    $.ajax({
      type: "POST",
      url: "registrar.php",
      data: form+'&agregarUsuario=si',
      success: function(done) {
        document.querySelector("#alr").innerHTML = done;
        $("#alr").css({
          "transform": "translate(0)",
          "left": "10px"
        });

        if ($("#alr .alert").hasClass('valido')) {
          setTimeout(function() {
            location.reload();
          }, 3000);
        }
      }
    }); //Terminamos la Funcion Ajax
  });

  document.querySelector("#log-cont input").onkeypress = function(e) {
		if (e.keyCode == 13) {
			$("#log-cont .submit.login").trigger('click');
		}
	};
});
</script>
</body>
</html>
<?php
}
?>