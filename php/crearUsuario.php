<?php
function crearUsuariosPorDefecto() {
	$usuariosDefecto = '{
    "usuarios": [
        {
        	"id": 0,
        	"usuario": "AngelKrak",
        	"contrasena": "$2y$10$M3Vwzc5.GFUtjNB9rPysROFpvdwR785FqscJFl96YfLDLD0K2ddUa",
        	"rango": "Administrador",
        	"datos_personales": {
        		"email": "angel-krak@hotmail.com",
        		"imagen_perfil": "http://s33.postimg.org/u99hgsi65/1_AE_1.jpg",
        		"nombre": "Angel Ramirez"
        	}
        },
        {
            "id": 1,
            "usuario": "demo",
            "contrasena": "$2y$10$EeigGQbOcGBySZlqNDiOLOXS7Pj1X03RheXq1CU64gW1YnTr166yO",
            "rango": "Usuario",
            "datos_personales": {
                "email": "demo@hotmail.com",
                "imagen_perfil": "http://s33.postimg.org/yf3qnv7y7/11082184_827586850649348_3904751569705898816_o.jpg",
                "nombre": "Soy una Prueba"
            }
        },
        {
            "id": 2,
            "usuario": "Dawud89",
            "contrasena": "$2y$10$9RUub2wZUYYK0mJvjLEfcOVrCdIVEEgW9hVykH.Cs3uhifgAnjPO6",
            "rango": "Administrador",
            "datos_personales": {
                "email": "dawud@hotmail.com",
                "imagen_perfil": "http://vignette2.wikia.nocookie.net/starcraftpedia/images/9/9c/Jim_Raynor_SC2_Perfil_1.jpg/revision/latest/scale-to-width-down/220?cb=20120430010157&path-prefix=es",
                "nombre": "Dawud89ph"
            }
        }
    ]
}';

	$crearUsuarios = fopen("../admin/php/usuarios.json", "w+");
	fwrite($crearUsuarios, $usuariosDefecto);
	fclose($crearUsuarios);
}

function crearUsuarioNuevo($usuario, $email, $contrasena, $imagen, $Nombres) {
	$usuariosNuevo = '{
    "usuarios": [
        {
            "id": 0,
            "usuario": "'.$usuario.'",
            "contrasena": "'.$contrasena.'",
            "rango": "Administrador",
            "datos_personales": {
                "email": "'.$email.'",
                "imagen_perfil": "'.$imagen.'",
                "nombre": "'.$Nombres.'"
            }
        }
    ]
}';

	$crearUsuarios = fopen("../admin/php/usuarios.json", "w+");
	fwrite($crearUsuarios, $usuariosNuevo);
	fclose($crearUsuarios);
}

$jsondata = array();
if(isset($_REQUEST['crearUsuario'])) {
	if ($_REQUEST['metodo'] == 'usuarioNew') {
		$usuario = $_REQUEST['NombredeUsuario'];
		$email = $_REQUEST['email'];
		$contrasena = sha1($_REQUEST['Contrasena']);
		$imagen = $_REQUEST['imagen'];
		$Nombres = $_REQUEST['Nombres'];

	  $jsondata['mensaje'] = "<div id='error' class='alert alert-success' role='alert'>Se ha Creado con Exito el Usuario <strong>".$_REQUEST['crearUsuario']."</strong>
	  <p>Seras Redireccionado en 5 Segundos</p>
	  <script type='text/javascript'>setTimeout(function() { location.reload(); }, 6300);</script></div>";
	  crearUsuarioNuevo($usuario, $email, $contrasena, $imagen, $Nombres);

	  header('Content-type: application/json; charset=utf-8');
	  echo json_encode($jsondata);
	} elseif ($_REQUEST['metodo'] == 'mantenerUsuarios') {
		$jsondata['mensaje'] = "<div id='error' class='alert alert-success' role='alert'>Se han Creado con Exito los Usuarios por Defecto
		<p>Seras Redireccionado en 5 Segundos</p>
		<script type='text/javascript'>setTimeout(function() { location.reload(); }, 6300);</script></div>";
		crearUsuariosPorDefecto();

	  header('Content-type: application/json; charset=utf-8');
	  echo json_encode($jsondata);
	}
}
?>