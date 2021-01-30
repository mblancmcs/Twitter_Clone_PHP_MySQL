<?php

	session_start();

	if(!isset($_SESSION['usuario'])){
		header('Location: index.php?erro=1');
	}

	require_once('db.class.php');

	$objDb = new db();
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
			$(document).ready(function(){
				$('#btn_tweet').click(function(){

					if($('#texto_tweet').val().length > 0){
						
						$.ajax({
							url: 'inclui_tweet.php',
							method: 'post',
							data: $('#form_tweet').serialize(),
							success: function(data){
							$('#texto_tweet').val('');
							atualizaTweet();
							}
						})
					}

				});

				function atualizaTweet(){//carrega os tweets

					$.ajax({
						url: 'get_tweet.php',
						success: function(data){
							$('#tweets').html(data);
						}
					});

				}

				atualizaTweet();

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
	    				<form id="form_tweet" class="input-group">
	    					<input type="text" id="texto_tweet" name="texto_tweet" clas="form-control" placeholder="O que está acontecendo agora ?" maxlength="140" />
	    					<span class="input-group-btn">
	    						<button class="btn btn-default" id="btn_tweet" type="button">Tweet</button>
	    					</span>
	    				</form>
	    			</div>
	    		</div>

	    		<div id="tweets" class="list-group">
	    			
	    		</div>

			</div>
			<!-- Deve-se criar uma tabela para os tweets
				CREATE TABLE tweet(
    				id_tweet int not null PRIMARY KEY AUTO_INCREMENT,
    				id_usuario int not null,
    				tweet varchar(140) not null,
    				data_inclusao datetime default CURRENT_TIMESTAMP
				);
			-->
			<div class="col-md-3  col-sm-3  col-xs-3">
				<div class="panel panel-default">
					<div class="panel-body">
						<h4><a href="procurar_pessoas.php">Procurar por pessoas</a></h4>
					</div>
				</div>
			</div>

		</div>


	    </div>
	
		<!--A inclusão do js do bootstrap no final é para que depois dos elementos bootstrap renderizados, seja associado eles com o js do bootstrap, pois se for feito antes, não há nada renderizado para ser associado as funções js-->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	
	</body>
</html>