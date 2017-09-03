<?php
include 'config.php';
$config = fopen("config.php", 'w+') or die("Error al Editar la Configuracion");

if ($_REQUEST['themes']) {
	$tema_select = $_REQUEST['themes'];
} else {
	$tema_select;
}

fwrite($config, '<?php
	$titulo_web = "'.$titulo_web.'";
	$slogan = "'.$slogan.'";
	$tema_select = "'.$tema_select.'";
	$version = "'.$version.'";
?>');

$host  = $_SERVER['HTTP_HOST'];
$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$base = "http://" . $host . $uri . "/";
$a = str_replace("php", "themes", $base);
if ($host == "localhost") {
	echo $a.$tema_select;
}
?>