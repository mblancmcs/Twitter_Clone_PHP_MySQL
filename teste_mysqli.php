<?php
	
	require_once('db.class.php'); //para trazer para dentro do script, o conteúdo contido no link chamado

	$sql = " SELECT * FROM usuarios ";

	$objDb = new db(); //variável que referencia o objeto
	$link = $objDb->conecta_mysql();

	//iremos usar o: UPDATE, INSERT, SELECT e DELETE
	//OBS: Todos acima, menos o SELECT retornam true ou false, caso a resposta seja positiva ou negativa, PORÉM, o SELECT retorna false caso haja um problema na consulta, ou um resource (referência para uma informação externa do php); é com ele que podemos recuperar o dados da consulta através de uma estrutura de objetos ou de arrays; e é com ele também, que podemos recuperar essa referência de resource, e explorar através de outras funções da biblioteca.

	$resultado_id = mysqli_query($link, $sql); // para recuperar o retorno do resorce referente a essa consulta, ou seja, é a referência para uma informação externa do php

	if($resultado_id){

		$dados_usuario = array();

		while($linha = mysqli_fetch_array($resultado_id, MYSQLI_ASSOC)){ // A função retorna apenas 1 registro dos dados passados por parâmetro a ela;
		// Quando não houver mais registros para serem retornados, o retorno da função será falso e o while irá parar

		// O segundo parâmetro que é a  função MYSQLI_NUM, retorna apenas o índice numérico, ao invés de trazer também o associativo, que no caso, contem: o id, usuario, email e senha -> Interessante ao fazer relatórios
		// Assim como se quiser retornar o associativo, pode-se usar o MYSQLI_ASSOC -> Interessante quando formos trazer os dados para um formulário e edita-los posteriormente
		// Quando retorna os 2, o parâmetro está sendo omitido, mas se quiser podemos usa-lo, é o MYSQLI_BOTH

			$dados_usuario[] = $linha;

		}

		/*
		echo '<pre>';
			var_dump($dados_usuario); // caso o retorno não seja encontrado, retornará NULL; já no print_r, retornará vazio (empty)
		echo '</pre>';
		*/

		foreach($dados_usuario as $usuario){ //Para retornar do array $dados_usuario, cada $usuario
			echo '<pre>';
				var_dump($usuario['email']); // pode-se utilizar o print_r também, além do echo caso seja apenas uma informação ($usuario['email']), e não um array
			echo '</pre>';
		}

	} else {

		echo 'Erro na execução da consulta (ERRO DE SINTAXE OU INSTRUÇÕES DE CONSULTA ----->>>>>SQL<<<<<-----), favor entrar em contato com o admin do site';

	}

	


?>