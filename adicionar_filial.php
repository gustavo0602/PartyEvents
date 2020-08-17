<?php
	include('conexao.php');
	session_start();
?>
<html>
	<head>
		<script type="text/javascript" src="js/jquery-3.2.1.min"></script>
		<script type="text/javascript" src="js/funcao.js"></script> 
	</head>
		<body>
		<form action="" method="POST">	
					<label>Nome:</label></br>
  					<input  name="nome_filial" type="text" placeholder="Digite o nome da empresa.."/>
  					</br><br>
  					<label>Email:</label></br>
  					<input name="email" type="email" placeholder="Digite o email da empresa.." />
  					</br></br>
  					<label>Telefone</label></br>
  					<input name="telefone" type="text" placeholder="Digite o telefone da empresa.." maxlength="9"/>
  					</br></br>
  					<div class="col-xs-4">
						Estado:</br>
						<select class="form-control" id="estado" name="estado">
						<option>Cidades - Selecione um estado..</option>
						<?php
								$sqlsel=('SELECT * FROM estado;');
								$resul=mysqli_query($conexao, $sqlsel);
								while($con=mysqli_fetch_array($resul))
								{
									$id=$con['id_estado'];
									$sigla=$con['sigla'];
									$nome=$con['nome'];
									if($con['id_estado'])
							?>
						
						<option value="<?php echo($id); ?>"><?php echo($sigla); ?> - <?php echo($nome); ?></option>
					  		<?php
								}
							?>
						</select>
					</div>
					<div class="col-xs-4">
						</br>Cidade
						 <select class="form-control" id="cidade" name="cidade">
							<option>Cidades - Selecione um estado primeiro..</option>
						</select>
					</div>
 					</br>
    			<button type="Submit" name="adicionar">Adicionar Filial</button>
    		</form>	
		<?php
			if(isset($_POST['adicionar']))
			{
			
				$nome=$_POST['nome_filial'];
				$email=$_POST['email'];
				$telefone=$_POST['telefone'];
				$cidade=$_POST['cidade'];
				$select=('SELECT id_empresa FROM empresa WHERE id_empresa="'.$_SESSION['id_empresa'].'";');
				$result=mysqli_query($conexao,$select);
				while($con=mysqli_fetch_array($result))
				{
					$fk=$con['id_empresa'];
				}
			
				if(!empty($nome) && !empty($email) && !empty($telefone) && !empty($cidade))
				{
					$sqlsel=('SELECT * FROM empresa WHERE email="'.$email.'";');//Vê se já tem um USUARIO EMPRESA com esse email
					$result=mysqli_query($conexao, $sqlsel);
					if(mysqli_num_rows($result))
					{
						echo('<script>window.alert("Esse email está indisponível! Tente outro!");window.location="adicionar_filial.php";</script>'); 
					}
					else
					{
						$sqlin=('INSERT INTO filiais(nome, email, telefone, dt_cadastro, fk_cidade_emp_fil, fk_empresa) VALUES ("'.$nome.'","'.$email.'","'.$telefone.'","2000-02-21","'.$cidade.'",'.$fk.');');
						mysqli_query($conexao, $sqlin);
						echo('<script>window.alert("Adicionado com sucesso!");window.location="adicionar_filial.php";</script>'); 
					}
				}
				else
				{
					echo('<script>window.alert("Preencha os campos!");window.location="adicionar_filial.php";</script>'); 
				}
			}	
			
		?>
		</body>
</html>