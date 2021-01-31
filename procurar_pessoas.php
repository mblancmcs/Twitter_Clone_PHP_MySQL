<?php

	session_start();

	if(!isset($_SESSION['usuario'])){ //se o índice 'usuario' NÃO EXISTE na variável de sessão
		header('Location: index.php?erro=1');
	}

	require_once('db.class.php');

	$objDb = new db(); //variável que referencia o objeto
	$link = $objDb->conecta_mysql();

	$id_usuario = $_SESSION['id_usuario'];

	// Consulta para recuperar a quantidade de tweets
	$sql = " SELECT COUNT(*) AS qnt_tweets FROM tweet WHERE id_usuario = $id_usuario ";
	
	$resultado_id = mysqli_query($link, $sql);

	$qtd_tweets = 0;

	if($resultado_id){
		$registro = mysqli_fetch_array($resultado_id, MYSQLI_ASSOC);

		$qtd_tweets = $registro['qnt_tweets'];

	} else {
		echo 'Erro ao executar a query';
	}
	

	// Consulta para recuperar a quantidade de seguidores
	$sql = " SELECT COUNT(*) AS qtd_seguidores FROM usuarios_seguidores WHERE seguindo_id_usuario = $id_usuario ";
	
	$resultado_id = mysqli_query($link, $sql);

	$qtd_seguidores = 0;

	if($resultado_id){
		$registro = mysqli_fetch_array($resultado_id, MYSQLI_ASSOC);

		$qtd_seguidores = $registro['qtd_seguidores'];

	} else {
		echo 'Erro ao executar a query';
	}

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

		<script type="text/javascript">
			
			//JQuery
			$(document).ready(function(){ //caso o documento esteja pronto, associaremos uma função
				//associar o evento de click ao botão
				$('#btn_procurar_pessoa').click(function(){

					if($('#nome_pessoa').val().length > 0){
						
						$.ajax({
							url: 'get_pessoas.php',
							method: 'post',
							//data: { texto_tweet: $('#texto_tweet').val() }, //data: { indice1 = valor1, indice2 = valor2 },
							data: $('#form_procurar_pessoas').serialize(),
							//Para fazer mais de uma vez (formulário muito grande), e não fazer como na instrução acima várias vezes. Porém precisa ser um form, e colocar um name (que tem que coincidir com o índice da super global em questão - GET - no script de destino 'get_pessoas.php') no input para servir como índice (chave) para a função serialize formar o JSON
							success: function(data){ //o data recupera o conteúdo de get_pessoas.php
								$('#pessoas').html(data);
								$('.btn_seguir').click( function(){
									var id_usuario = $(this).data('id_usuario');

									//Quando for acionado o evento de click na classe btn_seguir (ou btn_deixar_seguir), será recuperado o id do botão pelo '#btn_seguir_'+id_usuario, onde é concatenado pelo + (é assim aqui no JQuery) com a variável que já recuperou esse id pelo data-id_usuario do HTML 5 que está no script get_pessoas.php  E caso isso acima ocorra, o botão de seguir desaparecerá pela função hide() e o botão de deixar de seguir daquele id aparecerá com o show()
									$('#btn_seguir_'+id_usuario).hide();
									$('#btn_deixar_seguir_'+id_usuario).show();


									$.ajax({
										url: 'seguir.php',
										method: 'post',
										data: { seguir_id_usuario: id_usuario }, //passando um JSON já que não tem um formulário
										success: function(data){
											alert('Registro efetuado com sucesso');
										}
									});
								});

								$('.btn_deixar_seguir').click( function(){
									var id_usuario = $(this).data('id_usuario');

									$('#btn_seguir_'+id_usuario).show();
									$('#btn_deixar_seguir_'+id_usuario).hide();

									$.ajax({
										url: 'deixar_seguir.php',
										method: 'post',
										data: { deixar_seguir_id_usuario: id_usuario }, //passando um JSON já que não tem um formulário
										success: function(data){
											alert('Registro removido com sucesso');
										}
									});
								});
							}
						})
					}

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
	          	<li><a href="home.php">Home</a></li>
	            <li><a href="sair.php">Sair</a></li>
	          </ul>
	        </div><!--/.nav-collapse -->
	      </div>
	    </nav>


	    <div class="container">

	    	<div class="col-md-3 col-sm-3  col-xs-3">
	    		<div class="panel panel-default">
	    			<div class="panel-body">
	    				<h4><?= $_SESSION['usuario'] ?></h4>
	    				<br />
	    				<?= $_SESSION['email'] ?>
	    				<hr/>
	    				<div class="col-md-6 col-sm-6">
	    					TWEETS<br />
	    					<?= $qtd_tweets ?>
	    				</div>
	    				<div class="col-md-6 col-sm-6">
	    					SEGUIDORES<br />
	    					<?= $qtd_seguidores ?>
	    				</div>
	    			</div>
	    		</div>
	    	</div>
	    	<div class="col-md-6  col-sm-6  col-xs-6">
	    		<div class="panel panel-default">
	    			<div class="panel-body">
	    				<form id="form_procurar_pessoas" class="input-group">
	    					<input type="text" id="nome_pessoa" name="nome_pessoa" clas="form-control" placeholder="Quem você está procurando" maxlength="140" />
	    					<span class="input-group-btn">
	    						<button class="btn btn-default" id="btn_procurar_pessoa" type="button">Procurar</button>
	    					</span>
	    				</form>
	    			</div>
	    		</div>

	    		<div id="pessoas" class="list-group">
	    			
	    		</div>

			</div>
			<!-- Deve-se criar uma tabela para os tweets
				CREATE TABLE usuarios_seguidores(
    				id_usuario_seguidor int not null PRIMARY KEY AUTO_INCREMENT,
    				id_usuario int not null, /* vai armazenar o id autenticado, ou seeja, da sessão */
    				seguindo_id_usuario int not null, /* id do usuário que irá seguir para criar a relação entre o usuário da sessão e o que irá seguir */
    				data_registro datetime default CURRENT_TIMESTAMP
    			);
);
			-->
			<div class="col-md-3  col-sm-3  col-xs-3">
				<div class="panel panel-default">
					<div class="panel-body">
						
					</div>
				</div>
			</div>

		</div>


	    </div>
	
		<!--A inclusão do js do bootstrap no final é para que depois dos elementos bootstrap renderizados, seja associado eles com o js do bootstrap, pois se for feito antes, não há nada renderizado para ser associado as funções js-->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	
	</body>
</html>