<?php
	$conexao=mysqli_connect('localhost','root','','party_events') or die ('Falha na conex�o! '.mysqli_error());
	mysqli_set_charset($conexao, 'utf8');
?>