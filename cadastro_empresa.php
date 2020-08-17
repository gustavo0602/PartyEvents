<?php
	include('conexao.php');
?>
<html>
	<head>
		<title>Cadastrar Empresa</title>
		<meta charset="UTF-8">
		
		<!-- Importações JavaScript - Pra funcionar a seleção das cidades -->
		<script type="text/javascript" src="js/jquery-3.2.1.min"></script>
		<script type="text/javascript" src="js/funcao.js"></script> 
	</head>
	<body>
		<form action="#" method="POST" name="cadastro_empresa" enctype="multipart/form-data" >	
			<label>Nome</label></br>
  			<input  name="nome_emp" type="text" placeholder="Digite o nome da empresa.."/>
  			</br></br>
  			<label>Email</label></br>
  			<input name="email" type="email" placeholder="Digite o email da empresa.." />
  			</br></br>
			<label>Ramo da empresa</label>
			<div class="col-xs-4">
				<select class="form-control" name="ramo_evento">
					<option>Qual o tipo de evento que a empresa trabalho?</option>
					<option value="1">Aniversários e Festas Infantis</option>
					<option value="2">Casamentos</option>
					<option value="3">Debutantes</option>
					<option value="4">Formaturas</option>
					<option value="5">Conferências Corporativas</option>
				</select>
			</div>
			</br>
  			<label>CNPJ</label></br>
  			<input name="cnpj" type="text" placeholder="Digite o CNPJ.." maxlength="18"/>
  			</br></br>
  			<label>Telefone</label></br>
  			<input name="telefone" type="text" placeholder="Digite o telefone da empresa.." maxlength="9"/>
  			</br></br>
 
			<label>Em qual cidade a empresa fica?</label>
			</br>
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
  			<label>Imagem de Perfil</label></br></br>
  			<input name="arquivo" type="file"/>
  			</br></br>
			<label>Senha</label></br>
  			<input name="senha" type="password" placeholder="Digite sua senha.."/>
  			</br></br>
  			<label>Confirmação de senha</label></br>
  			<input name="senha1" type="password"  placeholder="Confirme sua senha.."/>
  			</br></br>
    		<button type="Submit" name="cadastrar">Cadastrar empresa</button>
    		<a href="login.php"><input type="button" value="Já tenho uma conta"></a>
    		<p><a href="index.php"><input type="button" value="Voltar ao site"></a></p>
    	</form>	
 		<?php
 			if(isset($_POST['cadastrar']))
 			{
				$nome_emp=$_POST['nome_emp'];
				$email=$_POST['email'];
				$ramo_evento=$_POST['ramo_evento'];
				$cnpj=$_POST['cnpj'];
				$telefone=$_POST['telefone'];
				$cidade=$_POST['cidade'];
				$senha=$_POST['senha'];
				$senha1=$_POST['senha1'];
				$tipo=2;
				if(!empty($nome_emp) && !empty($email)&& !empty($ramo_evento) && !empty($cnpj) && !empty($cidade) && !empty($telefone) && !empty($senha) && !empty($senha1))
				{
					$senha=sha1(strtolower(trim($senha)));//tira espaços que estao em branco, deixa tudo minusculo e so depois criptografa
					$senha1=sha1(strtolower(trim($senha1)));
					if($senha==$senha1)//senhas criptografadas sendo comparadas
					{
						$sqlsel=('SELECT * FROM empresa WHERE email="'.$email.'";');//Vê se já tem um USUARIO EMPRESA com esse email
						$result=mysqli_query($conexao, $sqlsel);
						if(mysqli_num_rows($result))
						{
							echo('<script>window.alert("Esse email está indisponível! Tente outro!");window.location="cadastro_empresa.php";</script>'); 
						}
						else
						{
							$sqlsel=('SELECT * FROM cliente WHERE email="'.$email.'";');//Vê se já tem um USUARIO CLIENTE com esse email
							$result=mysqli_query($conexao, $sqlsel);
							if(mysqli_num_rows($result))
							{
								echo('<script>window.alert("Esse email está indisponível! Tente outro!");window.location="cadastro_empresa.php";</script>');
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
										$sqlin=('INSERT INTO empresa(nome, email, ramo_empresa, cnpj, telefone, senha, dt_cadastro, img_perfil, fk_cidade_emp, tipo) VALUES ("'.$nome_emp.'","'.$email.'","'.$ramo_evento.'","'.$cnpj.'","'.$telefone.'","'.$senha.'","2000-02-21","'.$novoNome.'",'.$cidade.','.$tipo.');');
								mysqli_query($conexao, $sqlin);
										echo('<script>window.alert("Cadastrado com sucesso!");window.location="login.php";</script>'); 
									}
								}
							}
							//se ele não selecionar uma imagem, automaticamente vai inserir a imagem default
							else
							{
								$sqlin=('INSERT INTO empresa(nome, email, ramo_empresa, cnpj, telefone, senha, dt_cadastro,img_perfil, fk_cidade_emp, tipo) VALUES ("'.$nome_emp.'","'.$email.'","'.$ramo_evento.'","'.$cnpj.'","'.$telefone.'","'.$senha.'","2000-02-21","default.jpg",'.$cidade.','.$tipo.');');
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