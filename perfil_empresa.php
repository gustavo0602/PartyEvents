<?php
	include('conexao.php');
	session_start();
?>
<html>
	<head>
   		<meta charset="utf-8">
    	<title>Party e Events</title>
		<!-- Importações JavaScript -->
		<script type="text/javascript" src="js/jquery-3.2.1.min"></script>
		<script type="text/javascript" src="js/funcao.js"></script>
  	</head>
	<body>
	<?php
		$select_img=('SELECT img_perfil FROM empresa WHERE id_empresa="'.$_SESSION['id_empresa'].'";'); //seleciona a imagem de perfil dele
		$result=mysqli_query($conexao,$select_img);
		while ($con=mysqli_fetch_array($result))
		{
		 	echo ("<img src='imagens_perfil/".$con['img_perfil']."' height='20%'>");//mostra a imagem
		}
	?>
		<form action="#" method="POST">
			<button type="Submit" name="alt_img">Alterar imagem</button>
		</form>
	<?php
		IF(isset($_POST['alterar']))//quando clicar no botão alterar
		{
			$select=('SELECT * FROM empresa WHERE id_empresa="'.$_SESSION['id_empresa'].'";');
			$result=mysqli_query($conexao,$select);
			$con=mysqli_fetch_array($result);
	?>
		<form action="#" method="POST">
			Empresa:<br> <input type="text" name="nome_alt" value="<?php echo ($con['nome']);?>"><br>
			<input type="hidden" name="senha_alt" value="<?php echo ($con['senha']);?>">
			<input type="hidden" name="tipo_alt" value="<?php echo ($con['tipo']);?>">
			<input type="hidden" name="img_alt" value="<?php echo ($con['img_perfil']);?>">
			<input type="hidden" name="data_alt" value="<?php echo ($con['dt_cadastro']);?>">
			Email:<br> <input type="email" name="email_alt" value="<?php echo($con['email']);?>"><br>
			<input type="hidden" name="email_antigo" value="<?php echo($con['email']);?>">
			Telefone:<br> <input type="text" name="telefone_alt" value="<?php echo($con['telefone']);?>"><br>
			CNPJ:<br> <input type="text" name="cnpj_alt"  value="<?php echo($con['cnpj']);?>"><br>
			Ramo de atuação:</br>
			<div class="col-xs-4">
				<select class="form-control" name="ramo_alt">
					<option>Qual o tipo de evento que a empresa trabalho?</option>
					<option value="1" selected="selected">Aniversários e Festas Infantis</option>
					<option value="2" >Casamentos</option>
					<option value="3" >Debutantes</option>
					<option value="4" >Formaturas</option>
					<option value="5" >Conferências Corporativas</option>
				</select>
			</div>
			<div class="col-xs-4">
				Estado:</br>
				<select class="form-control" id="estado" name="estado">
				<?php
						$sqlsel=('SELECT * FROM estado WHERE id_empresa="'.$_SESSION['id_empresa'].'";');
						$resul=mysqli_query($conexao, $sqlsel);
						while ($con=mysqli_fetch_array($resul))
						{
							
				?>
					  <option value="" selected="selected"><?php echo $con['nome']; ?></option>
				<?php
						}
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
				Cidade </br>
				<select class="form-control" id="cidade" name="cidade" >
				<?php
						$select=('SELECT fk_cidade_emp FROM empresa WHERE id_empresa="'.$_SESSION['id_empresa'].'";');
						$result=mysqli_query($conexao,$select);
						$con=mysqli_fetch_array($result);
						$select_nome=('SELECT nome FROM cidade WHERE id_cidade="'.$con['fk_cidade_emp'].'";');
						$result=mysqli_query($conexao,$select_nome);
						
						while($con=mysqli_fetch_array($result)){
						
							
				?>
					  <option><?php echo $con['nome'];?></option>
						<?php
						}
						?>
				</select>
			</div>
			</br></br><button type="Submit" name="salvar">Salvar</button>
		</form>
	<?php
		}
		else
		{
			$select=('SELECT * FROM empresa WHERE id_empresa="'.$_SESSION['id_empresa'].'";');
			$result=mysqli_query($conexao,$select);
			while($con=mysqli_fetch_array($result))
			{
				echo ('<br>'."Empresa: ".$con['nome']);
				echo ('<br>'."Email: ".$con['email']);
				echo ('<br>'."Telefone: ".$con['telefone']);
				echo ('<br>'."CNPJ: ".$con['cnpj']);
				echo ('<br>'."Ramo de atuação: ".$con['ramo_empresa']);
			}
			$select=('SELECT fk_cidade_emp FROM empresa WHERE id_empresa="'.$_SESSION['id_empresa'].'";');
			$result=mysqli_query($conexao,$select);
			$con=mysqli_fetch_array($result);
			$select_nome=('SELECT nome FROM cidade WHERE id_cidade="'.$con['fk_cidade_emp'].'";');
			$result=mysqli_query($conexao,$select_nome);
			$con=mysqli_fetch_array($result);
			echo '<br>Cidade ou região: '.$con['nome'];
	?>
		</br></br><form action="#" method="POST"><button type="Submit" name="alterar">Alterar Informações</button>
		<button type="Submit" name="filial">Adicionar uma filial</button></form>
	<?php
		}
			if(isset($_POST['salvar']))
			{
				$senha=$_POST['senha_alt'];
				$tipo=$_POST['tipo_alt'];
				$img_perfil=$_POST['img_alt'];
				$dt_cadastro=$_POST['data_alt'];
				$empresa=$_POST['nome_alt'];
				$email=$_POST['email_alt'];
				$email_antigo=$_POST['email_antigo'];
				$ramo=$_POST['ramo_alt'];
				$cnpj=$_POST['cnpj_alt'];
				$telefone=$_POST['telefone_alt'];
				$cidade=$_POST['cidade'];
				if(!empty($senha) && !empty($tipo) &&!empty($img_perfil) && !empty($dt_cadastro) && !empty($empresa)&& !empty($email)&& !empty($ramo)&& !empty($cnpj)&& !empty($telefone)&& !empty($cidade))			
				{
						$sqlsel=('SELECT * FROM empresa WHERE email="'.$email.'" and email != "'.$email_antigo.'";');
						$result=mysqli_query($conexao, $sqlsel);
						if(empty(mysqli_num_rows($result)))
						{
							$sqlalt=('UPDATE empresa set nome="'.$empresa.'" , email="'.$email.'" , ramo_empresa="'.$ramo.'" , cnpj="'.$cnpj.'" , telefone="'.$telefone.'" , senha="'.$senha.'" , dt_cadastro="'.$dt_cadastro.'" , img_perfil="'.$img_perfil.'" , fk_cidade_emp="'.$cidade.'" , tipo='.$tipo.' WHERE id_empresa="'.$_SESSION['id_empresa'].'";');
							mysqli_query($conexao,$sqlalt);
							echo('<SCRIPT>window.alert("Alterado com sucesso!");window.location="perfil_empresa.php";</SCRIPT>'); 
						}
						else
						{
							echo('<script>window.alert("Esse email está indisponível! Tente outro!");window.location="perfil_empresa.php";</script>'); 
						}
						
				}
				else
				{
					echo('<SCRIPT>window.alert("Preencha os campos!");window.location="perfil_empresa.php";</SCRIPT>'); 
				}
			}
			If(isset($_POST['filial']))
			{
				header('Location: adicionar_filial.php');
			}	
		?>
		
	<h2>Informações do plano contratado</h2>
	Plano Contratado: xxxx</br>
	Dias restantes para expirar: x
	</br></br>
	<form action="#" method="POST">
		<button type="Submit" name="plano">Ver meu plano</button>
		<button type="Submit" name="alterar_plano">Alterar plano</button>
	</form>
	<h2>Estatística no site</h2>
	</br>Total de visitas:
	</br>Avaliação da empresa:     
	</br>Total de avaliações feitas
	</br>Contratações realizadas:
	<h2>Histórico de respostas de orçamentos</h2>
	<ul>
		<li>Orçamento xxx do usuario xxxx   <button type="Submit" name="">Ver detalhes</button></li></br>
		<li>Orçamento yyy do usuario yyyy   <button type="Submit" name="">Ver detalhes</button></li></br>
		<li>Orçamento zzz do usuario zzzzz   <button type="Submit" name="">Ver detalhes</button></li></br>
	</ul>
	</body>
</html>


