<?php 
require('../dbconnect.php');

if(isset($_POST['fornecedor']) && isset($_POST['endereco'])){
	$database->beginTransaction(); 

	$endereco = $_POST['endereco'];
	$queryEndereco = $database->prepare("insert into endereco(rua, bairro, cidade, estado, numero, cep, ponto_referencia, complemento) 
		values(:rua, :bairro, :cidade, :estado, :numero, :cep, :ponto_referencia, :complemento)");
	foreach ($endereco as $key => $value) {
	    $queryEndereco->bindValue(':'.$key, $value, PDO::PARAM_STR);
	}
	
	if(!$queryEndereco->execute()){
		echo print_r($queryEndereco->errorInfo());
	}
	else{
		$data = $_POST['fornecedor'];
		$query = $database->prepare("insert into fornecedor(nome, cnpj, endereco_id, email) values(:nome, :cnpj, :endereco_id, :email)");
		foreach ($data as $key => $value) {
		    $query->bindValue(':'.$key, $value, PDO::PARAM_STR);
		}

		$endereco_id = $database->lastInsertId('endereco_id_seq');
		$query->bindValue(':endereco_id', $endereco_id, PDO::PARAM_STR);

		if($query->execute()){
			$database->commit();
			header("Location: index.php?msg=create");
			die();
		}	
		else{
			echo print_r($query->errorInfo());
		}
	}
}
?>