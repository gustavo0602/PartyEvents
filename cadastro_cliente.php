<?php
	include('conexao.php');
?>
<html>
	<head>
		<title>Cadastrar Cliente</title>
		<meta charset="UTF-8">
		
		<!-- Importações JavaScript -->
		<script type="text/javascript" src="js/jquery-3.2.1.min"></script>
		<script type="text/javascript" src="js/funcao.js"></script>
	</head>
	<body>
		<form action="#" method="POST" name="cadastro_empresa" enctype="multipart/form-data" >	
			<label>Nome</label></br>
  			<input  name="nome_usu" type="text" placeholder="Digite o seu nome.."/>
  			</br></br>
  			<label>Sobrenome</label></br>
  			<input name="sobrenome" type="text" placeholder="Digite o seu sobrenome.."/>
  			</br></br>
  			<label>Email</label></br>
  			<input name="email" type="email" placeholder="Digite o seu email.." />
  			</br></br>
  			<label>Telefone</label></br>
  			<input name="telefone" type="text" placeholder="Digite o seu telefone.." maxlength="9"/>
  			</br></br>
  			<label>Data da Nascimento</label></br>
  			<input name="data" type="date" id="campoData"/>
  			</br></br>
			<label>Onde você mora?</label>
  			<div class="col-xs-4">
				</br>Estado <select class="form-control" id="estado" name="estado">
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
			</div>
			<div class="col-xs-4">
				</br>Cidade <select class="form-control" id="cidade" name="cidade">
					<option>Cidades - Selecione um estado primeiro..</option>
				</select>
			</div>
  			</br>
  			<label>Sexo</label></br>
  			<input type="radio" name="sexo" value="M" checked> Masculino 
			<input type="radio" name="sexo" value="F"> Feminino
			<input type="radio" name="sexo" value="O"> Outros
			</br></br>
			<label>Imagem de Perfil</label>
			</br></br>
  			<input name="arquivo" type="file"/>
  			</br></br>
			<label>Senha</label></br>
  			<input name="senha" type="password" placeholder="Digite sua senha.."/>
  			</br></br>
  			<label>Confirmação de senha</label></br>
  			<input name="senha1" type="password"  placeholder="Confirme sua senha.."/>
  			</br></br>
    		<button type="Submit" name="cadastrar">Cadastrar</button>
    		<a href="login.php"><input type="button" value="Já tenho uma conta"></a>
    		<p><a href="index.php"><input type="button" value="Voltar ao site"></a></p>
    		
    	</form>	
 		<?php
 			if(isset($_POST['cadastrar']))
 			{
				$nome_usu=$_POST['nome_usu'];
				$sobrenome=$_POST['sobrenome'];
				$email=$_POST['email'];
				$dt_nascimento=$_POST['data'];
				$telefone=$_POST['telefone'];
				$cidade=$_POST['cidade'];
				$sexo=$_POST['sexo'];
				$senha=$_POST['senha'];
				$senha1=$_POST['senha1'];
				$tipo=1;
				if(!empty($nome_usu) && !empty($sobrenome) && !empty($email)&& !empty($dt_nascimento) && !empty($cidade) && !empty($telefone) && !empty($sexo) && !empty($senha) && !empty($senha1))
				{
					$senha=sha1(strtolower(trim($senha)));//tira espaços que estao em branco, deixa tudo minusculo e so depois criptografa
					$senha1=sha1(strtolower(trim($senha1)));
					if($senha==$senha1)//senhas criptografadas sendo comparadas
					{
						$sqlsel=('SELECT * FROM cliente WHERE email="'.$email.'";');//Vê se já tem um USUARIO CLIENTE com esse email
						$result=mysqli_query($conexao, $sqlsel);
						if(mysqli_num_rows($result))
						{
							echo('<script>window.alert("Esse email está indisponível! Tente outro!");window.location="cadastro_cliente.php";</script>'); 
						}
						else
						{
							$sqlsel=('SELECT * FROM empresa WHERE email="'.$email.'";');//Vê se já tem um USUARIO EMPRESA com esse email
							$result=mysqli_query($conexao, $sqlsel);
							if(mysqli_num_rows($result))
							{
								echo('<script>window.alert("Esse email está indisponível! Tente outro!");window.location="cadastro_cliente.php";</script>');
							}
							else
							{
								// verifica se foi enviado um arquivo 
							if(isset($_FILES['arquivo']['name']) && $_FILES["arquivo"]["error"] == 0)
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
										$sqlin=('INSERT INTO cliente(nome, sobrenome, email, senha, dt_nascimento, telefone, dt_cadastro, sexo, img_perfil, fk_cidade_cli, tipo) VALUES ("'.$nome_usu.'","'.$sobrenome.'","'.$email.'","'.$senha1.'","'.$dt_nascimento.'",'.$telefone.',"'.$dt_nascimento.'","'.$sexo.'","'.$novoNome.'","'.$cidade.'","'.$tipo.'");');
										mysqli_query($conexao, $sqlin); 
										echo('<script>window.alert("Cadastrado com sucesso!");window.location="login.php";</script>'); 
									}
								}
							}
							//se ele não selecionar uma imagem, automaticamente vai inserir a imagem default
							else
							{
								$sqlin=('INSERT INTO cliente(nome, sobrenome, email, senha, dt_nascimento, telefone, dt_cadastro, sexo, img_perfil, fk_cidade_cli, tipo) VALUES ("'.$nome_usu.'","'.$sobrenome.'","'.$email.'","'.$senha1.'","'.$dt_nascimento.'",'.$telefone.',"'.$dt_nascimento.'","'.$sexo.'","default.jpg","'.$cidade.'","'.$tipo.'");');
								mysqli_query($conexao, $sqlin); 
								echo('<script>window.alert("Cadastrado com sucesso!");window.location="login.php";</script>'); 
							}
						}
					}
				}
					else
					{
						echo('<script>window.alert("Senhas diferentes!");window.location="#";</script>'); 
					}
				}
				else
				{
					echo('<script>window.alert("Preencha os campos!");window.location="#";</script>'); 
				}
			}
		?>
	</body>
</html>