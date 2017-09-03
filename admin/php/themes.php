<?php
function listar_carpetas($carpeta) {
//le añadimos la barra a la carpeta que le hemos pasado
$ruta = $carpeta . "/";
 
//pasamos a minúsculas (opcional)
$ruta = strtolower($ruta);
 
//comprueba si la ruta que le hemos pasado es un directorio
if(is_dir($ruta)) {
//fijamos la ruta del directorio que se va a abrir
if($dir = opendir($ruta)) {
//si el directorio se puede abrir
while(($archivo = readdir($dir)) !== false) {
//le avisamos que no lea el "." y los dos ".."
if($archivo != '.' && $archivo != '..') {
//comprobramos que se trata de un directorio
if (is_dir($ruta.$archivo)) {
//si efectivamente es una carpeta saltará a nuestra próxima función
leer_carpeta($ruta.$archivo);
} } }
//cerramos directorio abierto anteriormente
closedir($dir);
} } }

//recogemos  la ruta para entrar en el segundo nivel
function leer_carpeta($leercarpeta) {
require '../php/config.php';
//le añadimos la barra final
$leercarpeta = $leercarpeta;
 
if(is_dir($leercarpeta)){
if($dir = opendir($leercarpeta)){
while(($archivo = readdir($dir)) !== false){
if($archivo == 'preview.png') {
echo "<label>
<input type='radio' class='theme_sel' name='themes' value='".substr($leercarpeta, 10)."' style='display: none;' />
<picture id='preview' class='".substr($leercarpeta, 10)."' style='background-image: url(\"".$leercarpeta."/".$archivo."\");'><div class='selected'><span class='name_theme'>".substr($leercarpeta, 10)." Theme</span>";
if ($tema_select == substr($leercarpeta, 10)) {
	echo "<span id='selected_theme'>TEMA SELECCIONADO</span>";
}
echo "</div></picture>
</label>";
}
}
 
closedir($dir);
} } }
?>