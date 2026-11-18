<?php
if (isset($_COOKIE['administrador'])) {
	require_once 'model/Administrador.php';
	
	$administrador=new Administrador();
	$administrador->deslogar();
	header('location:index.php');
}
?>
