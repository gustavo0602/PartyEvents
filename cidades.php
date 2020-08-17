<?php
	include('conexao.php');
	
	$id=$_GET['id'];
	$sqlsel=('SELECT * FROM cidade WHERE fk_estado="'.$id.'" ORDER BY nome;');
	$resul=mysqli_query($conexao, $sqlsel);
	while($con=mysqli_fetch_array($resul))
	{
		$nome=$con['nome'];
		$id_cidade=$con['id_cidade'];
		
		echo('<option value="'.$id_cidade.'" class="cidade">'.$nome.'</option>');
	}
?>