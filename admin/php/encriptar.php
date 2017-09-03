<?php
$encriptar = $_REQUEST['hash'];

echo password_hash($encriptar, PASSWORD_BCRYPT);
?>