<?php

	require_once('db.class.php'); //para trazer para dentro do script, o conteúdo contido no link chamado

	$usuario = $_POST['usuario'];
	$email = $_POST['email'];
	$senha = md5($_POST['senha']); // retornará um hash baseado no método md5

	// importado o arquivo db.class.php, podemos fazer uma instância da classe e gerar um objeto de conexão com o banco de dados
	$objDb = new db(); //variável que referencia o objeto
	$link = $objDb->conecta_mysql(); //usamos a variável que referencia o objeto, para executar a função de conexão ao banco de dados e atribuímos o retorno dessa função (que precisa ser recuperado), a uma outra variável para usarmos mais a frente

	$usuario_existe = false;
	$email_existe = false;

	//MONTANDO A QUERY
	//Primeiro deve-se criar uma tabela no phpMyAdmin
	/*
	create table usuarios(
	    id int not null PRIMARY KEY AUTO_INCREMENT,
	    usuario varchar(50) not null,
	    email varchar(100) not null,
	    senha varchar(32) not null /*32 porque mais pra frente no curso iremos aprender a usar a criptografia md5, e ela gera um hash de 32  caracteres, que tem como objetivo ocultar a informação de senha
    );
    */

    //verificar se o usuário já existe
    $sql = "select * from usuarios where usuario = '$usuario' ";
    if($resultado_id = mysqli_query($link, $sql)){

    	$dados_usuario = mysqli_fetch_array($resultado_id);

    	if(isset($dados_usuario['usuario'])){ //se o índice usuario da variável dados_usuario existir
    		$usuario_existe = true;
    	}

    } else {
    	echo 'Erro ao tentar localizar o registro de usuário';
    }

    echo '<hr />';

    //verificar se o email já existe
    $sql = "select *  from usuarios where email = '$email' ";
    if($resultado_id = mysqli_query($link, $sql)){

    	$dados_usuario = mysqli_fetch_array($resultado_id);

    	if(isset($dados_usuario['email'])){ //se o índice usuario da variável dados_usuario existir // se fosse utilizado o usuario ao invés de email, não haveria porblema, pois na nova query, está sendo recuperado agora, o email, analisando todos os registros com o asterístico, no select
    		$email_existe = true;
    	}

    } else {
    	echo 'Erro ao tentar localizar o registro de e-mail';
    }

    if($usuario_existe || $email_existe){

    	$retorno_get = ''; //parametrizaremos a variável de acordo com os parâmetros que precisamos enviar por get

    	if($usuario_existe){
    		$retorno_get .= "erro_usuario=1&"; // o .= é para cocatenar a variável com a string // o E comercial (&) serve para delimitar as variáveis e seus valores, sendo assim muito importante, pois senão na url, o que vier depois será entendido como atribuição a primieira variável passada por get
    	}

    	if($email_existe){
    		$retorno_get .= "erro_email=1&";
    	}

    	header('Location: inscrevase.php?' . $retorno_get);
    	die(); //Responsável por parar a leitura do script, para não gerar inserts no banco de dados desnecessários como abaixo
    	
    }

    $sql = " insert into usuarios(usuario, email, senha) values('$usuario', '$email', '$senha') ";

    //executar a query (E TRATAR COM O IF O RETORNO DA FUNÇÃO (MUITO IMPORTANTE), porquê quando há algum erro de sintaxe, ela retorna o valor de false)
    if(mysqli_query($link, $sql) ){ //1º parâmetro: a conexão com o banco de dados (o $link que retorna o $con (retorno) da função conecta_mysql()) e 2º parametro: o sql (a query);
    	echo 'Usuário registrado com sucesso';
    } else {
    	echo 'Erro ao registrar o usuário';
    }

    //Tratando quando há erro de sintaxe 



?>