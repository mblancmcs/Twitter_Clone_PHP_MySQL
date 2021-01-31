<?php

	session_start();

	if(!isset($_SESSION['usuario'])){ //se o índice 'usuario' NÃO EXISTE na variável de sessão
		header('Location: index.php?erro=1');
	}

	require_once('db.class.php'); //para trazer para dentro do script, o conteúdo contido no link chamado

	$id_usuario = $_SESSION['id_usuario'];

	$objDb = new db(); //variável que referencia o objeto
	$link = $objDb->conecta_mysql();

	// PARA FACILITAR A LEITURA É CONCATENADO A QUERY DE CIMA COM A DE BAIXO PELO .=
	$sql = "  SELECT DATE_FORMAT(t.data_inclusao, '%d %b %Y %T') AS data_inclusao_formatada, t.tweet, u.usuario "; //cada coluna (data_inclusao, tweet e usuario) será um índice para a variável do tipo array $registro mais a frente
	$sql .= " FROM tweet AS t JOIN usuarios AS u ON(t.id_usuario = u.id) ";
	$sql .= " WHERE id_usuario = $id_usuario";
	$sql .= " OR id_usuario IN(SELECT seguindo_id_usuario FROM usuarios_seguidores WHERE id_usuario = $id_usuario) "; // Pode-se usar sub-queries através do IN, onde é esperado que se o campo a esquerda id_usuario corresponda a algum dos parâmetros passados no IN, retorne verdadeiro
	$sql .= " ORDER BY data_inclusao DESC ";

	$resultado_id = mysqli_query($link, $sql);

	if($resultado_id){

		while($registro = mysqli_fetch_array($resultado_id, MYSQLI_ASSOC)){
			echo '<a href = "#" class="list-group-item"> '; // a ideia de usar o href é para reaproveitar a class do bootstrap list-group, para usar uma outra dela
				echo '<h4 class="list-group-item-heading"> ' . $registro['usuario'] . ' <small> - ' . $registro['data_inclusao_formatada'] . ' </small></h4> '; //destaque a parte superior da postagem
				echo '<p class="list-group-item-text">' . $registro['tweet'] . '</p>';
			echo '</a>';
		}

	} else {
		echo 'Erro na consulta de tweets no banco de dados !';
	}

?>