<html>
	<head>
		<title>Recuperacao</title>
	</head>
	<body>
		<form action="#" method="POST">
			Digite seu email:</br></br> 
			<input type="email" name="email" placeholder="Digite seu email.."></br></br>
			<input type="submit" name="enviar" value="Enviar">
			<a href="login.php"><input type="button" value="Voltar"></a>
		</form>
			<?php
				include('conexao.php');
					if(isset($_POST['enviar']))
					{
						$email=$_POST['email'];
						if(!empty($email))
						{
			 				$sql_busca="SELECT * FROM usuario WHERE  email='".$email."';";
							$query=mysqli_query($conexao, $sql_busca);
							$con=mysqli_num_rows($query);
							if(empty($con))
							{
								echo 'Usuário não encontrado! <br />';
							}
							$dados = mysqli_fetch_array($query);
							$emailsql = $dados['email'];
							$senha = $dados['senha'];
							$nome = $dados['nome'];
							//Se os E-mails Forem Iguais//
							if ($email == $emailsql)
					 		{
				    			$mensagem = "Presado sr. ".$nome.",<br><br>";
				   				$mensagem .= "Esta mensagem foi enviada ao senhor pois solicitou a recuperação de seus dados de login em nosso site. Abaixo seguem seus dados:";
				   				$mensagem .= "Senha: ".$senha."</p>";
				    			$headers = "MIME-Version: 1.0\r\n";
				   				$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
				    			ini_set( $mensagem, $headers);
				    			echo "<b>Seus dados foram enviados com sucesso!</b>";
				   			 }
							//Caso os E-mails não são Iguais//
				   			else
				   			 {
				   				echo "<b>Os dados informados nao sao compativeis com os cadastrados! Tente novamente!</b>";
				   			 }
						}
					}
			?>
	</body>
</html>
