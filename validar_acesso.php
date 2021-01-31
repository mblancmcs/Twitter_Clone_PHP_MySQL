<?php

	session_start();
	
	require_once('db.class.php'); //para trazer para dentro do script, o conteúdo contido no link chamado

	// é atribuída a variáveis para facilitar a escrita do´código
	$usuario = $_POST['usuario'];
	$senha = md5($_POST['senha']); //criptografando no login para que o método MD5, compare com o hash presente no banco de dados (ao efetuar a inscrição) com o criado no login

	//OBS CRIPTOGRAFIA MD5: O MySQL suporta a criptografia MD5 também, ou seja, caso seja necessário criptografar algum dado lá gravado, dá para usar um: SELECT md5('dado'), usar essa informação passada e aualizar o dado gravado por um UPDATE. Exemplo: UPDATE usuarios SET senha = 'e10adc3949ba59abbe56e057f20f883e' WHERE id = 1;

	$sql = " SELECT id, usuario, email FROM usuarios WHERE usuario = '$usuario' AND senha = '$senha' "; // Prestar atenção no operador para o registro ser considerado como válido corretamente: é utilizado o AND (E)

	$objDb = new db(); //variável que referencia o objeto
	$link = $objDb->conecta_mysql();

	//iremos usar o: UPDATE, INSERT, SELECT e DELETE
	//OBS: Todos acima, menos o SELECT retornam true ou false, caso a resposta seja positiva ou negativa, PORÉM, o SELECT retorna false caso haja um problema na consulta, ou um resource (referência para uma informação externa do php); é com ele que podemos recuperar o dados da consulta através de uma estrutura de objetos ou de arrays; e é com ele também, que podemos recuperar essa referência de resource, e explorar através de outras funções da biblioteca.

	$resultado_id = mysqli_query($link, $sql); // para recuperar o retorno do resorce referente a essa consulta, ou seja, é a referência para uma informação externa do php

	if($resultado_id){

		$dados_usuario = mysqli_fetch_array($resultado_id); // a função retorna os dados passados por parâmetro a ela

		if(isset($dados_usuario['usuario'])){ //índice usuario que é definido na instrução SQL (registro)

			$_SESSION['id_usuario'] = $dados_usuario['id'];
			$_SESSION['usuario'] = $dados_usuario['usuario'];
			$_SESSION['email'] = $dados_usuario['email'];

			header('Location: home.php'); //enviando a uma página restrita utilizando session
		} else { //caso o usuário e senha fornecido, não correspondam a um registro no banco de dados
			header('Location: index.php?erro=1'); // com esse parâmetro, só pode ser enviado por get
		}

		/*
		echo '<pre>';
			var_dump($dados_usuario); // caso o retorno não seja encontrado, retornará NULL; já no print_r, retornará vazio (empty)
		echo '</pre>';
		*/

	} else {

		echo 'Erro na execução da consulta (ERRO DE SINTAXE OU INSTRUÇÕES DE CONSULTA ----->>>>>SQL<<<<<-----), favor entrar em contato com o admin do site';

	}

	


?>