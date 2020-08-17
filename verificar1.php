<?php
	session_start();
	if(isset($_SESSION['id'])) // verifica se o usuario esta logado 
	{
	
	}	
	else
	{
		header('location:destruir.php');
	}
?>