<?php 
require('../dbconnect.php');

if(isset($_POST['produto'])){
	$data = $_POST['produto'];
	$query = $database->prepare("update produto set nome=:nome, descricao=:descricao, preco_venda=:preco_venda where id=:id");
	foreach ($data as $key => $value) {
	    $query->bindValue(':'.$key, $value, PDO::PARAM_STR);
	}
	if($query->execute()){
		header("Location: index.php?msg=update");
		die();
	}	
	else{
		echo print_r($query->errorInfo());
	}
}
?>