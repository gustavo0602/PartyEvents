<!DOCTYPE html>
<?php
	include('conexao.php');
	session_start();
	if(isset($_SESSION['logado']))// vê se o usuário está logado
	{
		$sqlcliente=('SELECT * FROM cliente WHERE id_cliente="'.$_SESSION['id_cliente'].'";');
		$resulcliente=mysqli_query($conexao, $sqlcliente);
		$concliente=mysqli_fetch_array($resulcliente);
?>
<html lang="pt-br">
	<head>
 		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Meu Perfil</title>
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
	                    <li><a class="page-scroll" href="">FALE CONOSCO</a></li>
						<li><a href="destruir.php">SAIR</a></li>
                	</ul>
            	</div>
        	</div>
    	</nav>
			<form method="POST" action="#" enctype="multipart/form-data">
				<?php
					//Pegando informações do cliente como, sexo, localização e tal
					if($concliente['sexo']=='M') //Sexo
					{
						$sexo='Masculino';
					}
					else if($concliente['sexo']=='F')
					{
						$sexo='Feminino';
					}
					else
					{
						$sexo='Outros';
					}
					
					$cidade_do_cliente=('SELECT * FROM cidade WHERE id_cidade="'.$concliente['fk_cidade_cli'].'";'); //Cidade
					$resul_cidade_do_cliente=mysqli_query($conexao, $cidade_do_cliente);
					$con_cidade_do_cliente=mysqli_fetch_array($resul_cidade_do_cliente);
					
					$estado_do_cliente=('SELECT * FROM estado WHERE id_estado="'.$con_cidade_do_cliente['fk_estado'].'";'); //Estado
					$resul_estado_do_cliente=mysqli_query($conexao, $estado_do_cliente);
					$con_estado_do_cliente=mysqli_fetch_array($resul_estado_do_cliente);
					
					echo('
						<div class="container text-center">
			            	<div class="row">
			            		<div class="col-md-8 col-md-offset-2">
			               			<h2 class="section-heading">Historico de Orcamentos</h2>
									<img src="imagens_perfil/'.$concliente['img_perfil'].'" width="25%">
									<br><br>
						');
					
					if(isset($_POST['alterar_info']))
					{
						echo('
							<p align="center"><input type="file" name="arquivo"/></p>
							<p>Nome: <input type="text" name="nome_usu" value="'.$concliente['nome'].'"/></p>
							<p>Sobrenome: <input type="text" name="sobrenome" value="'.$concliente['sobrenome'].'"/></p>
							<p>Email: <input type="text" name="email" value="'.$concliente['email'].'"/></p>
							<p>Telefone: <input type="text" name="telefone" value="'.$concliente['telefone'].'"/></p>
							<p>Data de Nascimento: <input type="date" name="data" value="'.$concliente['dt_nascimento'].'"/></p>
							<p>Estado atual: '.$con_estado_do_cliente['nome'].' - '.$con_estado_do_cliente['sigla'].'</p>
							');
							$sqlsel=('SELECT * FROM estado;');
							$resul=mysqli_query($conexao, $sqlsel);	
					?>
					<p>Estado <select class="form-control" id="estado" name="estado">
								<option value="" selected="selected">Escolha um estado</option>
									<?php
											$sqlsel=('SELECT * FROM estado;');
											$resul=mysqli_query($conexao, $sqlsel);
											while($con=mysqli_fetch_array($resul))
											{
												$id=$con['id_estado'];
												$sigla=$con['sigla'];
												$nome=$con['nome'];
										?>
								<option value="<?php echo($id); ?>"><?php echo($sigla); ?> - <?php echo($nome); ?></option>
									  	<?php
											}
										?>
							  </select>
					</p>
					<?php
						echo('
							<p>Cidade atual: '.$con_cidade_do_cliente['nome'].' CEP: '.$con_cidade_do_cliente['cep'].'</p>
							');
					?>
					<p>Cidade <select class="form-control" id="cidade" name="cidade">
								<option>Cidades - Selecione um estado primeiro..</option>
							  </select>
					</p>
					<?php
						echo('<p>Sexo: '.$sexo.'</p>
							<p> 
								<input type="radio" name="sexo" value="M" checked> Masculino 
								<input type="radio" name="sexo" value="F"> Feminino
								<input type="radio" name="sexo" value="O"> Outros
							</p>
							<p><input type="submit" name="alterar" value="Alterar"</p>
							');
					}
					else
					{
						echo('
							<h3>Usuario: '.$concliente['nome'].' '.$concliente['sobrenome'].'</h3>
							<p>Email: '.$concliente['email'].'</p>
							<p>Data de Nascimento: '.$concliente['dt_nascimento'].'</p>
							<p>Estado: '.$con_estado_do_cliente['nome'].' - '.$con_estado_do_cliente['sigla'].'</p>
							<p>Cidade: '.$con_cidade_do_cliente['nome'].' CEP: '.$con_cidade_do_cliente['cep'].'</p>
							<p>Sexo: '.$sexo.'</p>
							<p><input type="submit" name="alterar_info" value="Alterar Informacoes"</p>
							');
							
							// Pegando empresas favoritadas, históricos de orçamento e empresas contratadas
							$emp_fav=('SELECT * FROM empresa WHERE id_empresa="'.$concliente['emp_fav'].'";'); // Empresas Favoritas pelo usuário
							$resul_emp_fav=mysqli_query($conexao, $emp_fav);
							$con_emp_fav=mysqli_fetch_array($resul_emp_fav);
								
								// Historico de orçamento
								$hist_orca=('SELECT * FROM orcamento WHERE id_orcamento="'.$concliente['hist_orca'].'";'); // Pegando informações do orçamento em si
								$resul_hist_orca=mysqli_query($conexao, $hist_orca);
								$con_hist_orca=mysqli_fetch_array($resul_hist_orca);
								
								$emp_orca=('SELECT * FROM empresa WHERE id_empresa="'.$con_hist_orca['fk_empresa'].'";'); // Pegando as empresas desse orçamento
								$resul_emp_orca=mysqli_query($conexao, $emp_orca);
								$con_emp_orca=mysqli_fetch_array($resul_emp_orca);
								
							$emp_cont=('SELECT * FROM empresa WHERE id_empresa="'.$concliente['emp_cont'].'";'); // Empresas contratadas pelo usuário
							$resul_emp_cont=mysqli_query($conexao, $emp_cont);
							$con_emp_cont=mysqli_fetch_array($resul_emp_cont);
								
							echo('
								<div class="container text-center">
							       	<div class="row">
							       		<div class="col-md-8 col-md-offset-0">
							       			<h2 class="section-heading">Empresas que voce salvou</h2>
											');
											$ef=mysqli_num_rows($resul_emp_fav); // Conta a quantidade de linhas do banco de acordo com a query
											if($ef>0) // Vai listar as empresas
											{
												for($y=1;$y>=$x;$y++)
												{
													echo('<img src="imagens_empresas/'.$con_emp_fav['img_perfil'].'" width="15%">'); //Imagem da empresa salva
													echo($con_emp_fav['nome']); //Nome
												}
											}
											else
											{
												echo('Voce ainda nao salvou nenhuma empresa!');
											}
							echo('
										</div>
									</div>
								</div>
								');	
							echo('
								<div class="container text-center">
							       	<div class="row">
							       		<div class="col-md-8 col-md-offset-0">
							      			<h2 class="section-heading">Historico de Orcamentos</h2>
											');
											$cho=mysqli_num_rows($resul_hist_orca); // Conta a quantidade de linhas do banco de acordo com a query
											if($cho>0)
											{
												for($y=1;$y>=$x;$y++)
												{
													echo('Orçamento: '.$con_hist_orca['titulo'].' para as empresas '.$con_emp_orca['nome'].' <button type="Submit" name="">Ver detalhes</button>');
												}
											}
											else
											{
												echo('Voce ainda nao fez um orcamento para as empresas!');
											}
							echo('
										</div>
									</div>
								</div>
								');
							echo('
								<div class="container text-center">
							       	<div class="row">
							      		<div class="col-md-8 col-md-offset-0">
							       			<h2 class="section-heading">Historico de Contratacao</h2>
											');
											$cec=mysqli_num_rows($resul_emp_cont); // Conta a quantidade de linhas do banco de acordo com a query
											if($cec>0)
											{
												for($y=1;$y>=$x;$y++)
												{
													echo('<img src="imagens_empresas/'.$con_emp_fav['img_perfil'].'" width="15%">'); //Imagem da empresa salva
													echo($con_emp_fav['nome']); //Nome
												}
											}
											else
											{
												echo('Voce ainda nao fez um orcamento para as empresas!');
											}
							echo('
										</div>
									</div>
								</div>
							');
					}
					
					echo('
								</div>
							</div>
						</div>
						');
						
				?>
			</form>
			<?php
				if(isset($_POST['alterar']))
				{
					$nome_usu=$_POST['nome_usu'];
					$sobrenome=$_POST['sobrenome'];
					$email=$_POST['email'];
					$telefone=$_POST['telefone'];
					$dt_nascimento=$_POST['data'];
					$sexo=$_POST['sexo'];
					$cidade=$_POST['cidade'];
					if(!empty($nome_usu) && !empty($sobrenome) && !empty($email) && !empty($telefone) && !empty($dt_nascimento) && !empty($sexo) && !empty($cidade))
					{
						if(is_numeric($cidade)) // se for numero (id no caso) ele pegou uma cidade nova
						{
							$city=$cidade;
						}
						else // senao for um id e tal, eh porque veio a frase que esta no option, sendo assim, nao eh id e ele vai continuar com a cidade antiga
						{
							$city=$concliente['fk_cidade_cli'];
						}
						
						// vamos ver se ele mudou o email e se tem no banco
						if($concliente['email']==$email) // se for igual ao que ele estava usando nem precisa ver no banco
						{
							if(isset($_FILES['arquivo']['name']) && $_FILES["arquivo"]["error"] == 0) // sera que ele mudou a porra da imageme e upou outra?
							{
								$arquivo_tmp = $_FILES['arquivo']['tmp_name'];
								$nome = $_FILES['arquivo']['name'];
								// Pega a extensao
								$extensao = strrchr($nome, '.');
								// Converte para minusculo
								$extensao = strtolower($extensao);
								// Somente imagens, .jpg;.jpeg;.gif;.png
								// separando por ';'
								// Isso serve apenas para pesquisar dentro desta String
								if(strstr('.jpg;.jpeg;.gif;.png', $extensao))
								{
									// Cria um nome único para a imagem
									// Evita que duplique as imagens no servidor.
									$novoNome = md5(microtime()) . $extensao;
									// Concatena a pasta com o nome
									$destino = 'imagens_perfil/' . $novoNome; 
									// tenta mover o arquivo para o destino
									if( @move_uploaded_file( $arquivo_tmp, $destino ))
									{
										$sqlalt=('UPDATE cliente SET nome="'.$nome_usu.'", sobrenome="'.$sobrenome.'", dt_nascimento="'.$dt_nascimento.'", telefone='.$telefone.', sexo="'.$sexo.'", img_perfil="'.$novoNome.'", fk_cidade_cli='.$city.' WHERE id_cliente="'.$concliente['id_cliente'].'";');
										mysqli_query($conexao, $sqlalt);
										if(mysqli_affected_rows($conexao)) // se houve alteracoes nas linhas do banco eh porque foi atualizado
										{
											echo('<script>window.alert("Dados alterados com sucesso!");window.location="perfil_cliente.php";</script>');
										} 
										else
										{
											echo('<script>window.alert("A imagem de perfil deve ter tamanho inferior a 2 Mb!");window.location="perfil_cliente.php";</script>');
										}
									}
								}
							}
							else // ele nao mudou a imagem pasoekaspo
							{
								$sqlalt=('UPDATE cliente SET nome="'.$nome_usu.'", sobrenome="'.$sobrenome.'", dt_nascimento="'.$dt_nascimento.'", telefone='.$telefone.', sexo="'.$sexo.'", img_perfil="'.$concliente['img_perfil'].'", fk_cidade_cli='.$city.' WHERE id_cliente="'.$concliente['id_cliente'].'";');
								mysqli_query($conexao, $sqlalt);
								if(mysqli_affected_rows($conexao)) // se houve alteracoes nas linhas do banco eh porque foi atualizado
								{
									echo('<script>window.alert("Dados alterados com sucesso!");window.location="perfil_cliente.php";</script>');
								}
								else
								{
									echo('<script>window.alert("A imagem de perfil deve ter tamanho inferior a 2 Mb!");window.location="perfil_cliente.php";</script>');
								} 
							}
						}
						else // senao for igual, tem que ver se tem cliente ou empresa usando, pois vai ser um email novo
						{
							$sql_email_cli=('SELECT * FROM cliente WHERE email="'.$email.'";'); // select dos clientes
							$resul_sql_email_cli=mysqli_query($conexao, $sql_email_cli);
							
							$sql_email_emp=('SELECT * FROM empresa WHERE email="'.$email.'";'); // select das empresas
							$resul_sql_email_emp=mysqli_query($conexao, $sql_email_emp);
							
							if(mysqli_num_rows($resul_sql_email_cli)) // verifica se ja tem cliente com o email
							{
								echo('<script>window.alert("O email que deseja alterar esta indisponivel, tente outro!");window.location="perfil_cliente.php";</script>');
							}
							elseif(mysqli_num_rows($resul_sql_email_emp)) // verifica se ja tem empresa com o email
							{
								echo('<script>window.alert("O email que deseja alterar esta indisponivel, tente outro!");window.location="perfil_cliente.php";</script>');
							}
							else // vai ser email novo hehehe
							{
								if(isset($_FILES['arquivo']['name']) && $_FILES["arquivo"]["error"] == 0) // mesma coisa se ele tivesse email, so que atualizando o email
								{
									$arquivo_tmp = $_FILES['arquivo']['tmp_name'];
									$nome = $_FILES['arquivo']['name'];
									// Pega a extensao
									$extensao = strrchr($nome, '.');
									// Converte para minusculo
									$extensao = strtolower($extensao);
									// Somente imagens, .jpg;.jpeg;.gif;.png
									// separando por ';'
									// Isso serve apenas para pesquisar dentro desta String
									if(strstr('.jpg;.jpeg;.gif;.png', $extensao))
									{
										// Cria um nome único para a imagem
										// Evita que duplique as imagens no servidor.
										$novoNome = md5(microtime()) . $extensao;
										// Concatena a pasta com o nome
										$destino = 'imagens_perfil/' . $novoNome; 
										// tenta mover o arquivo para o destino
										if( @move_uploaded_file( $arquivo_tmp, $destino ))
										{
											$sqlalt=('UPDATE cliente SET nome="'.$nome_usu.'", sobrenome="'.$sobrenome.'", email="'.$email.'", dt_nascimento="'.$dt_nascimento.'", telefone='.$telefone.', sexo="'.$sexo.'", img_perfil="'.$novoNome.'", fk_cidade_cli='.$city.' WHERE id_cliente="'.$concliente['id_cliente'].'";');
											mysqli_query($conexao, $sqlalt);
											if(mysqli_affected_rows($conexao)) // se houve alteracoes nas linhas do banco eh porque foi atualizado
											{
												echo('<script>window.alert("Dados alterados com sucesso!");window.location="perfil_cliente.php";</script>');
											}
											else
											{
												echo('<script>window.alert("A imagem de perfil deve ter tamanho inferior a 2 Mb!");window.location="perfil_cliente.php";</script>');
											}
										}
									}
								}
								else
								{
									$sqlalt=('UPDATE cliente SET nome="'.$nome_usu.'", sobrenome="'.$sobrenome.'", email="'.$email.'", dt_nascimento="'.$dt_nascimento.'", telefone='.$telefone.', sexo="'.$sexo.'", img_perfil="'.$concliente['img_perfil'].'", fk_cidade_cli='.$city.' WHERE id_cliente="'.$concliente['id_cliente'].'";');
									mysqli_query($conexao, $sqlalt);
									if(mysqli_affected_rows($conexao)) // se houve alteracoes nas linhas do banco eh porque foi atualizado
									{
										echo('<script>window.alert("Dados alterados com sucesso!");window.location="perfil_cliente.php";</script>');
									}
									else
									{
										echo('<script>window.alert("A imagem de perfil deve ter tamanho inferior a 2 Mb!");window.location="perfil_cliente.php";</script>');
									}
								}	
							}
						}
					}
					else
					{
						echo('<script>window.alert("Preencha todos os campos por gentileza!");window.location="perfil_cliente.php";</script>');
					}	
				}
			?>
	<!-- Rodapé -->
    <footer class="footer">
        <div class="container">
            <p>&copy; 2017 Party e Events. Todos direitos reservados.</p>
        </div>
    </footer>
	
    <!-- jQuery (obrigatório para plugins JavaScript do Bootstrap) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Inclui todos os plugins compilados (abaixo), ou inclua arquivos separadados se necessário -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
<?php
	}
	else
	{
		echo('VocÊ tem que estar logado SEU PNC!!!!!!!!!!!!!');
	}
?>