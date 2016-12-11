<?php 
require('../dbconnect.php');

if(isset($_POST['produto'])){
	$form = false;
	$data = $_POST['produto'];
	$query = $database->prepare("update produto set nome=:nome, descricao=:descricao, preco_venda=:preco_venda where id=:id");
	foreach ($data as $key => $value) {
	    $query->bindValue(':'.$key, $value, PDO::PARAM_STR);
	}
	if($query->execute()){
		echo "Produto atualizado que alegria";
		echo '<br><a href="index.php">Voltar</a>';
	}	
	else{
		echo print_r($query->errorInfo());
	}
}
?>