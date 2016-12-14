<?php
require('../dbconnect.php');

if(isset($_GET['id_pedido']) && isset($_GET['id_produto'])){

	$query = $database->prepare("UPDATE produto p
	SET quantidade_estoque = quantidade_estoque + (SELECT quantidade FROM item_pedido WHERE produto_id = p.id AND pedido_id = ".$_GET['id_pedido']." )
	WHERE id = ".$_GET['id_produto']);

	$query2 = $database->prepare("DELETE FROM item_pedido WHERE pedido_id = ".$_GET['id_pedido']." AND produto_id = ".$_GET['id_produto']);

	if($query->execute() && $query2->execute()){
		echo "ok";
	}
	else{
		print_r($query->errorInfo());
	}
}

?>