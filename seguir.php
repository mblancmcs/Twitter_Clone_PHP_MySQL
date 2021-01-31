<?php

	session_start();

	if(!isset($_SESSION['usuario'])){ //se o índice 'usuario' NÃO EXISTE na variável de sessão
		header('Location: index.php?erro=1');
	}

	require_once('db.class.php'); //para trazer para dentro do script, o conteúdo contido no link chamado

	$id_usuario = $_SESSION['id_usuario'];
	$seguir_id_usuario = $_POST['seguir_id_usuario'];

	//Esse tratamento é IMPORTANTE, pois se for igual a vazio, a função mysqli_query() não executará a query SQL
	if($seguir_id_usuario != '' && $id_usuario != ''){ // OU colocar um OU ao invés de E e caso sejam iguais (==) a vazio, realizar a função die();

		$objDb = new db(); //variável que referencia o objeto
		$link = $objDb->conecta_mysql();

		$sql = " INSERT INTO usuarios_seguidores(id_usuario, seguindo_id_usuario) values($id_usuario,  $seguir_id_usuario) "; // POR SER INTEIRO, NÃO É BOM USAR AS ASPAS

		mysqli_query($link, $sql);
	}

	

?>