<?php

	session_start();

	if(!isset($_SESSION['usuario'])){ //se o índice 'usuario' NÃO EXISTE na variável de sessão
		header('Location: index.php?erro=1');
	}

	require_once('db.class.php'); //para trazer para dentro do script, o conteúdo contido no link chamado

	$texto_tweet = $_POST['texto_tweet'];
	$id_usuario = $_SESSION['id_usuario'];

	//Esse tratamento é IMPORTANTE, pois se for igual a vazio, a função mysqli_query() não executará a query SQL
	if($texto_tweet == '' || $id_usuario == ''){ // OU colocar if($texto_tweet != '' && $id_usuario != '')
		die();
	}

	$objDb = new db(); //variável que referencia o objeto
	$link = $objDb->conecta_mysql();

	$sql = " INSERT INTO tweet(id_usuario, tweet) values('$id_usuario',  '$texto_tweet') ";

	mysqli_query($link, $sql);

?>