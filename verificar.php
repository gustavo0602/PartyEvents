<?php
	include('conexao.php');
	session_start();
	if(isset($_POST['acessar']))
	{
		$email=$_POST['email'];
		$senha1=sha1($_POST['senha']);
		if(!empty($email) && !empty($senha1))
		{
			if($_SESSION['tipouser']==1)
			{
				$sqlsel=("SELECT id_cliente FROM cliente WHERE email='".$email."' AND senha='".$senha1."';");
				$result=mysqli_query($conexao, $sqlsel);
				if(mysqli_num_rows($result))
				{
					$con=mysqli_fetch_array($result);
					//Cria uma variável global e da o ID do cliente que está logando pra ela 
					$_SESSION['id_cliente']=$con['id_cliente'];
					$_SESSION['logado']=1;
					echo('<SCRIPT>window.alert("Logado com sucesso");window.location="index.php";</SCRIPT>');	
				}
				else
				{
					echo('<SCRIPT>window.alert("Dados invalidos");window.location="destruir.php";</SCRIPT>'); 
				}
			}else if($_SESSION['tipouser']==2)
			{
				$sqlselemp=("SELECT id_empresa FROM empresa WHERE email='".$email."' AND senha='".$senha1."';");
				$resultemp=mysqli_query($conexao, $sqlselemp);
				if(mysqli_num_rows($resultemp))
				{
					$con=mysqli_fetch_array($resultemp);
					//Cria uma variável global e da o ID da empresa que está logando pra ela 
					$_SESSION['id_empresa']=$con['id_empresa'];
					$_SESSION['logado']=2;
					echo('<SCRIPT>window.alert("Logado com sucesso");window.location="index.php";</SCRIPT>');
				}
				else
				{
					echo('<SCRIPT>window.alert("Dados invalidos");window.location="destruir.php";</SCRIPT>'); 
				}
			}
			else
			{
				echo('<SCRIPT>window.alert("ADMINISTRADOR LOGANDO");window.location="index.php";</SCRIPT>');
			}
		}
		else
		{
			echo('<script>window.alert("Preencha os campos!");window.location="cadastro_empresa.php";</script>');
		}
	}
?>	