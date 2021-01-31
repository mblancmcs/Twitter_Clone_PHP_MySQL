
<?php
	
	//treinando o if ternário, mas no outro curso mais atualizado, o mesmo prof diz que não é recomendado usar ele
	$erro = isset($_GET['erro']) ? $_GET['erro'] : 0;

	echo $erro;

?>

<!DOCTYPE HTML>
<html lang="pt-br">
	<head>
		<meta charset="UTF-8">

		<title>Twitter clone</title>

		<!-- jquery - link cdn -->
		<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>

		<!-- bootstrap - link cdn -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	
		<script>
			//JQuery
			$(document).ready(function(){ //caso esteja pronto, executar uma função

				var campo_vazio = false; // para caso não preencha nenhum dos dois campos

				//verificar se os campos de usuário e senha foram devidamente preenchidos
				$('#btn_login').click(function(){

					if($('#campo_usuario').val() == ''){

						$('#campo_usuario').css({'border-color': '#A94442' });
						campo_vazio = true;
						//alert('Campo usuário está vazio');
					
					} else {
						$('#campo_usuario').css({'border-color': '#CCC' }); // CASO O ID (#) campo_usuario NÃO SEJA IGUAL A '' (VAZIO)
					}

					if($('#campo_senha').val() == ''){

						$('#campo_senha').css({'border-color': '#A94442' });
						//alert('Campo senha está vazio');
						campo_vazio = true;
					
					} else {
						$('#campo_senha').css({'border-color': '#CCC' }); // CASO O ID (#) campo_senha NÃO SEJA IGUAL A '' (VAZIO)
					}

					if(campo_vazio) 
						return false; // O RETURN FALSE NO EVENTO DE CLICK DO SUBMIT, IMPEDE QUE O FORMUÁRIO SEJA ENVIADO (CANCELA O DISPARO DA TRIGGER DO FORMULÁRIO)

				});

			});
		</script>
	</head>

	<body>

		<!-- Static navbar -->
	    <nav class="navbar navbar-default navbar-static-top">
	      <div class="container">
	        <div class="navbar-header">
	          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
	            <span class="sr-only">Toggle navigation</span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	          </button>
	          <img src="imagens/icone_twitter.png" />
	        </div>
	        
	        <div id="navbar" class="navbar-collapse collapse">
	          <ul class="nav navbar-nav navbar-right">
	            <li><a href="inscrevase.php">Inscrever-se</a></li>
	            <!--PRESTAR ATENÇÃO AQUI: SÓ DA PARA VER EM NO TAMANHO DE DESKTOP-->
	            <li class="<?= $erro == 1 ? 'open' : '' ?>">
	            <!--O bootstrap deixa a class como open quando é clicada, porém o que foi feito, foi que quando na url é passado o 'erro=1', ela já vem aberta para que o usuário já veja qual é o problema, mas caso não venha, esse parâmetro continuará vazio-->
	            	<a id="entrar" data-target="#" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Entrar</a>
					<ul class="dropdown-menu" aria-labelledby="entrar">
						<div class="col-md-12">
				    		<p>Você possui uma conta?</h3>
				    		<br />
							<form method="post" action="validar_acesso.php" id="formLogin">
								<div class="form-group">
									<input type="text" class="form-control" id="campo_usuario" name="usuario" placeholder="Usuário" />
								</div>
								
								<div class="form-group">
									<input type="password" class="form-control red" id="campo_senha" name="senha" placeholder="Senha" />
								</div>
								
								<button type="buttom" class="btn btn-primary" id="btn_login">Entrar</button>

								<br /><br />
								
							</form>

							<?php

								if($erro == 1){
									echo '<font color ="#FF0000"> Usuário ou senha inválido(s) </font>';
								} else {

								}

							?>

						</div>
				  	</ul>
	            </li>
	          </ul>
	        </div><!--/.nav-collapse -->
	      </div>
	    </nav>


	    <div class="container">

	      <!-- Main component for a primary marketing message or call to action -->
	      <div class="jumbotron">
	        <h1>Bem vindo ao twitter clone</h1>
	        <p>Veja o que está acontecendo agora...</p>
	      </div>

	      <div class="clearfix"></div>
		</div>


	    </div>

	    <!--A inclusão do js do bootstrap no final é para que depois dos elementos bootstrap renderizados, seja associado eles com o js do bootstrap, pois se for feito antes, não há nada renderizado para ser associado as funções js-->
	
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	
	</body>
</html>