<?php
	$conexao=mysqli_connect('localhost','root','','party_events') or die ('Falha na conexão! '.mysqli_error());
	mysqli_set_charset($conexao, 'utf8');
?>