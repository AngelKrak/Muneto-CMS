<?php
$usuariosURL = file_get_contents('../../../admin/php/usuarios.json');
$usuariosJSON = json_decode($usuariosURL);
session_start();
@$G = eval('return '. $_SESSION['usuario']. ';');

if(@$G){
?>
function main2() {
post = contenedor.getElementsByClassName('<?php echo strtolower($G); ?>').length; //Contamos cuantos Post hay
document.querySelector("#estadisticas .total.usuario").innerHTML = '<div class="post_totales">Post Creados</div><div class="count_post">'+ post +' Post</div>'; //Mostramos cuantos Post hay en Total
}
main2();
<?php } ?>