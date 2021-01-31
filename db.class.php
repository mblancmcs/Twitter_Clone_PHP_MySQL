<?php

	//criando uma classe de conexão com o banco de dados (há outras formas de criar essa conexão com o banco)
	//utilizando a extensão mysqli

	class db{

		//qual é o host (endereço onde o mysql está instalado) - como está instalado no computador (ou seja, a instância está local e isso significa que podemos utilizar o endereço localhost para identificar onde a instância do MySQL está instalada);
		private $host = 'localhost';

		//qual o usuário
		private $usuario = 'root'; //usuário administrador padrão na instalação do MySQL

		//qual a senha
		private $senha = ''; //por padrão já em como vazia na instalação do xampp, assim como o usuário como root, caso tenha trocado algum desses valores, trocar aqui

		//qual é o banco de dados onde iremos executar os comandos SQL
		//criar o banco de dados pelo phpMyAdmin com CREATE DATABASE twitter_clone
		private $database = 'twitter_clone';

		public function conecta_mysql(){

			//Criando a conexão com o bd: mysqli_connect(localização do bd, usuario de acesso, senha, banco de dados)
			$con = mysqli_connect($this->host, $this->usuario, $this->senha, $this->database); //após o comando a conexão está estabelecida

			//ajustar o charset entre a aplicação e o banco de dados. Recebe 2 parâmetros; o primeiro é: conexão com o banco de dados; e o segundo é: qual é o charset que será setado
			mysqli_set_charset($con, 'utf8');

			//verificar se houve erro de conexão
			if(mysqli_connect_errno()){ //essa função retorna um código de erro que senão for 0, existe erro na conexão com o banco de dados
				echo 'Erro ao tentar se conectar com o bd MySQL: ' . mysqli_connect_error(); //função que retorna a descrição do erro
			}

			return $con;

		}

	}

?>