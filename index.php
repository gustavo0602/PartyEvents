<!DOCTYPE html>
<?php
	include('conexao.php');
	session_start();
?>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Party e Events</title>
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
											<li><a href="perfil_cliente.php">Minha conta</a></li>
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
											<li><a href="perfil_empresa.php">Minha conta</a></li>
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
	
	<!-- Parte de pesquisa -->
	<header>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
					<div class="jumbotron text-center">
						<h1>Party e Events</h1>
						<p>Encontrar uma empresa de eventos nunca foi tão fácil</p>
						<form method="POST" action="resultado_pesquisa.php">
							<div class="row">
								<div class="col-xs-4">
									<select class="form-control" id="estado" name="estado">
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
									<select class="form-control" id="cidade" name="cidade">
									  <option>Cidades - Selecione um estado primeiro..</option>
									</select>
								</div>
								<div class="col-xs-4">
									<select class="form-control" name="evento">
									  <option>Qual o tipo do seu evento?</option>
									  <option value="Aniversários e Festas Infantis">Aniversários e Festas Infantis</option>
									  <option value="Casamentos">Casamentos</option>
									  <option value="Debutantes">Debutantes</option>
									  <option value="Formaturas">Formaturas</option>
									  <option value="Conferências Corporativas">Conferências Corporativas</option>
									</select>
								</div>
							</div>
							<br>
							<input type="submit" class="btn btn-primary btn-lg" role="button" value="Pesquisar" name="pesquisar">
						</div>
					</form>
				</div>
            </div>
        </div>
    </header>
	
	<!-- Quem somos -->
	<section class="bg-primary text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <h2 class="section-heading">Quem somos</h2>
                    <p>A plataforma Party & Events tem como objetivo interligar clientes e empresas de eventos, fazendo com que o cliente consiga o seu evento sem ter dificuldades e a empresa tenha facilidade em divulgar o seu trabalho em busca de clientes.</p>
                </div>
            </div>
        </div>
    </section>
	
	<!-- Empresas em destaque -->
	<section class="text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <h2 class="section-heading">Empresas em destaque</h2>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer auctor massa iaculis aliquam commodo.</p>
				
					<!-- Slideshow das empresas -->
					<img src="..." alt="..." class="img-thumbnail">
					
				</div>
            </div>
        </div>
    </section>
	
	<!-- Depoimentos -->
        <div class="container text-center">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <h2 class="section-heading">Depoimentos</h2>
					
					<!--Slideshow dos depoimentos -->
					<img src="..." alt="..." class="img-thumbnail">
					
				</div>
			</div>
		</div>
	
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
