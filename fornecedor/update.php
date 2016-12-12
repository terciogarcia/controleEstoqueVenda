<?php 
require('../dbconnect.php');

if(isset($_POST['fornecedor'])){
	$fornecedor = $_POST['fornecedor'];
	$endereco = $_POST['endereco'];

	$queryF = $database->prepare("UPDATE fornecedor SET nome=:nome, cnpj=:cnpj, email=:email WHERE id=:id;");
	$queryE = $database->prepare("UPDATE endereco SET rua=:rua, bairro=:bairro, cidade=:cidade, estado=:estado, numero=:numero,
		complemento=:complemento, cep=:cep, ponto_referencia=:ponto_referencia WHERE id = :id");

	foreach ($fornecedor as $key => $value) {
	    $queryF->bindValue(':'.$key, $value, PDO::PARAM_STR);
	}

	foreach ($endereco as $key => $value) {
	    $queryE->bindValue(':'.$key, $value, PDO::PARAM_STR);
	}

	if($queryF->execute() && $queryE->execute()){
		header("Location: index.php?msg=update");
		die();
	}	
	else{
		echo print_r($queryF->errorInfo());
		echo print_r($queryE->errorInfo());
	}
}
?>