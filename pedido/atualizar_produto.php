<?php
require('../dbconnect.php');

if(isset($_GET['id_pedido']) && isset($_GET['id_produto'])){
	if($_GET['aumentar']  == 1){
		$query = $database->prepare("SELECT quantidade_estoque FROM produto WHERE id = ".$_GET['id_produto']);
		$query->execute();
		$row = $query->fetch(PDO::FETCH_ASSOC); 
		if($row['quantidade_estoque'] == 0){
			echo 'erro';
			exit();
		}
		$query = $database->prepare("UPDATE item_pedido SET quantidade = quantidade+1 WHERE pedido_id = ".$_GET['id_pedido']." AND produto_id = ".$_GET['id_produto']);
		$query2 = $database->prepare("UPDATE produto SET quantidade_estoque = quantidade_estoque-1 WHERE id = ".$_GET['id_produto']);
	}
	else{
		$query = $database->prepare("UPDATE item_pedido SET quantidade = quantidade-1 WHERE pedido_id = ".$_GET['id_pedido']." AND produto_id = ".$_GET['id_produto']);
		$query2 = $database->prepare("UPDATE produto SET quantidade_estoque = quantidade_estoque+1 WHERE id = ".$_GET['id_produto']);
	}

	if(!$query->execute() || !$query2->execute()){
		print_r($query->errorInfo());
	}
	else{
		echo 'ok';
	}
}

?>