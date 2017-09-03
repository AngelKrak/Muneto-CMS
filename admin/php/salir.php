<?php
	//Iniciamos Sesion
   session_start();

   //Dirigimos al Login
   if (isset($_GET['logout'])) {
   	//Cerramos Session
	session_destroy();

      $regresar = $_SERVER['HTTP_REFERER'];
   	header ("Location: ".$regresar);
   }

   echo "No has Presionado el Boton Todavia, ¿Estas Seguro que deseas Salir?";
   echo "<br />";
   echo '<a href="salir.php?logout=0"><button id="si">Si</button></a> <a href="../index.php"><button id="no">No</button></a>';
?>