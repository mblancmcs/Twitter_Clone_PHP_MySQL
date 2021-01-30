<?php
	
	require_once('db.class.php');

	$sql = " SELECT * FROM usuarios ";

	$objDb = new db();
	$link = $objDb->conecta_mysql();

	$resultado_id = mysqli_query($link, $sql);

	if($resultado_id){

		$dados_usuario = array();

		while($linha = mysqli_fetch_array($resultado_id, MYSQLI_ASSOC)){

			$dados_usuario[] = $linha;

		}

		/*
		echo '<pre>';
			var_dump($dados_usuario); // caso o retorno não seja encontrado, retornará NULL; já no print_r, retornará vazio (empty)
		echo '</pre>';
		*/

		foreach($dados_usuario as $usuario){
			echo '<pre>';
				var_dump($usuario['email']); // pode-se utilizar o print_r também, além do echo caso seja apenas uma informação ($usuario['email']), e não um array
			echo '</pre>';
		}

	} else {

		echo 'Erro na execução da consulta (ERRO DE SINTAXE OU INSTRUÇÕES DE CONSULTA ----->>>>>SQL<<<<<-----), favor entrar em contato com o admin do site';

	}

	


?>