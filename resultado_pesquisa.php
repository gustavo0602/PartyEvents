<!DOCTYPE html>
<html lang="pt-br">
	<head>
 		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Resultado de pesquisa</title>
		<link href="css/bootstrap.min.css" rel="stylesheet">
	
		<!-- Importações JavaScript -->
		<script type="text/javascript" src="js/jquery-3.2.1.min"></script>
		<script type="text/javascript" src="js/funcao.js"></script>
	</head>
	<body>
		<!-- Barra de menu -->
		<nav class="navbar navbar-default navbar-fixed-top">
			<div class="container">
				<!-- Para Mobile irá abrir um Menu que conterá as opções -->
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
	                    Menu
					</button>
				<!-- Botão da Home, onde irá ao topo -->
	                <a class="navbar-brand page-scroll" href="index.php">Home</a>
	            </div>

	            <!-- O link para as outras páginas -->
	            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	                <ul class="nav navbar-nav navbar-right">
	                    <li><a class="page-scroll" href="">Fale Conosco</a></li>
						<?php
							include('conexao.php');
							session_start();
							if(isset($_SESSION['logado']))
							{
								if($_SESSION['logado']==1)
								{
									$sqlcliente=('SELECT * FROM cliente WHERE id_cliente="'.$_SESSION['id_cliente'].'";');
									$resultcliente=mysqli_query($conexao, $sqlcliente);
									$concliente=mysqli_fetch_array($resultcliente);
									echo('
										<li><a class="page-scroll" href="">Fazer um Orçamento</a></li>
										<li class="dropdown">
											<a href="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">'.$concliente['nome'].'  <span class="caret"></span></a>
											<ul class="dropdown-menu">
												<li><a href="">Minha conta</a></li>
												<li role="separator" class="divider"></li>
												<li><a href="destruir.php">Sair</a></li>
											</ul>
										</li>
										');
								}
								else if($_SESSION['logado']==2)
								{
									$sqlempresa=('SELECT * FROM empresa WHERE id_empresa="'.$_SESSION['id_empresa'].'";');
									$resultempresa=mysqli_query($conexao, $sqlempresa);
									$conempresa=mysqli_fetch_array($resultempresa);
									echo('
										<li><a class="page-scroll" href="">Orçamentos Solicitados</a></li>
										<li class="dropdown">
											<a href="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">'.$conempresa['nome'].'  <span class="caret"></span></a>
											<ul class="dropdown-menu">
												<li><a href="">Minha conta</a></li>
												<li role="separator" class="divider"></li>
												<li><a href="destruir.php">Sair</a></li>
											</ul>
										</li>
										');
								}
								else
								{
									echo('<li><a class="page-scroll" href="login.php">EU SOU ADMINISTRADOR</a></li>');
								}
							}
							else
							{
								echo('
									<li><a class="page-scroll" href="login.php">Login</a></li>
									<li><a class="page-scroll" href="cadastro.php">Cadastre-se</a></li>
									');
							}
						?>
                	</ul>
            	</div>
        	</div>
    	</nav>
			<?php
			if (empty ($_SESSION['id']))
			{
				if(isset($_POST['pesquisar']))
				{ 
					$cidade=$_POST['cidade'];
					$evento=$_POST['evento'];
					if(!empty($cidade) && !empty($evento))
					{
						$sql_cidade=('SELECT * FROM cidade WHERE id_cidade="'.$cidade.'";');
						$resul_cidade=mysqli_query($conexao, $sql_cidade);
						$controle_cidade=mysqli_fetch_array($resul_cidade);
						echo('<br><br>');
						echo('<h1 align="center"> Resultado de pesquisa  </h1>');
						echo('Cidade ou regiao: '.$controle_cidade['nome'].'<br> Tipo de evento: '.$evento.'<br><br>');
						$sql_empresa=('SELECT * FROM empresa WHERE ramo_empresa="'.$evento.'" AND fk_cidade_emp="'.$cidade.'";');// procurando a empresa 
						$resul_empresa=mysqli_query($conexao, $sql_empresa);
						if(mysqli_num_rows($resul_empresa))
						{ 	
							while($controle_empresa=mysqli_fetch_array($resul_empresa)) // loop pra mostrar as informacoes das empresas
							{ 
								//echo('<img src="'.$_SESSION['img'].'" alt="'.$controle_empresa['nome'].'" title="'.$controle_empresa['nome'].'">');// imagem da empresa
								echo($controle_empresa['nome'].'<br>');
								//echo('Ramo:'.$servico.'<br> Localizacao:'.$controle_cidade['nome'].'<br>');
								echo('<a href="perfil_empresa.php?id='.$controle_empresa['id_empresa'].'"> Ver empresa </a><br><br>');
							}
						}
						else
						{
							echo('Infelizmente nao ha empresas disponiveis na sua regiao :/'); // bugou a acentuação oaskeoaskeosek
						}
					}
					else
					{
						echo('<script>window.alert("Preencha os campos!");window.location="index.php";</script>');
					}
				}
}
			?>
	</body>
</html>