<?php

	class db{
		private $host = 'localhost';

		//qual o usuário
		private $usuario = 'root';

		//qual a senha
		private $senha = '';

		private $database = 'twitter_clone';

		public function conecta_mysql(){

			$con = mysqli_connect($this->host, $this->usuario, $this->senha, $this->database);

			mysqli_set_charset($con, 'utf8');

			if(mysqli_connect_errno()){
				echo 'Erro ao tentar se conectar com o bd MySQL: ' . mysqli_connect_error();
			}

			return $con;

		}

	}

?>