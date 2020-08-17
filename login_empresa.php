<!DOCTYPE html>
<html>
    <head>
		<meta charset="UTF-8">
		<title>Login Empresa</title>
	</head>
	<body>
		<form action="verificar.php" method="POST">
			<label>Email</label></br>
			<input type="email" name="email" placeholder="Digite o email da empresa.." required autofocus/></br></br>
			<label>Senha</label></br>
			<input type="password" name="senha" placeholder="Digite a senha.." />
			<br><br>
			<input type="submit" name="acessar" value="Acessar"></button>
			<p><a href="cadastro_cliente.php"><input type="button" value="Não tenho um login"></a>
			<a href="recuperacao.php"><input type="button" value="Esqueci minha senha"></a>
			<a href="index.php"><input type="button" value="Voltar ao site"></a></p>
			<p><a href="cadastro_empresa.php"><input type="button" value="Cadastre sua empresa"></a></p>
		</form>
		<?php
			session_start();
			$_SESSION['tipouser']=2;
		?>
	</body>
</html>
