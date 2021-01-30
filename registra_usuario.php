<?php

	require_once('db.class.php');

	$usuario = $_POST['usuario'];
	$email = $_POST['email'];
	$senha = md5($_POST['senha']); // retornará um hash baseado no método md5

	$objDb = new db();
	$link = $objDb->conecta_mysql();

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

    	if(isset($dados_usuario['email'])){
    		$email_existe = true;
    	}

    } else {
    	echo 'Erro ao tentar localizar o registro de e-mail';
    }

    if($usuario_existe || $email_existe){

    	$retorno_get = ''; //parametrizaremos a variável de acordo com os parâmetros que precisamos enviar por get

    	if($usuario_existe){
    		$retorno_get .= "erro_usuario=1&";
    	}

    	if($email_existe){
    		$retorno_get .= "erro_email=1&";
    	}

    	header('Location: inscrevase.php?' . $retorno_get);
    	die(); //Responsável por parar a leitura do script, para não gerar inserts no banco de dados desnecessários como abaixo
    	
    }

    $sql = " insert into usuarios(usuario, email, senha) values('$usuario', '$email', '$senha') ";

    if(mysqli_query($link, $sql) ){
    	echo 'Usuário registrado com sucesso';
    } else {
    	echo 'Erro ao registrar o usuário';
    }



?>