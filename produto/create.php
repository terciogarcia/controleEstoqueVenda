<?php 
require('../dbconnect.php');

if(isset($_POST['produto'])){
	$form = false;
	$data = $_POST['produto'];
	$query = $database->prepare("insert into produto(nome, descricao, preco_venda) values(:nome, :descricao, :preco_venda)");
	foreach ($data as $key => $value) {
	    $query->bindValue(':'.$key, $value, PDO::PARAM_STR);
	}
	if($query->execute()){
		header("Location: index.php?msg=create");
		die();
	}	
	else{
		echo print_r($query->errorInfo());
	}
}
?>