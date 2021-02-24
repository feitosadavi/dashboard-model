<?php 
	require_once("../componentes/ControleSessao.php");
	session_start();
	
	$sessionController = new SessionController();
	$sessionController->destroy();
	header("Location:../../public/default.php");
?>