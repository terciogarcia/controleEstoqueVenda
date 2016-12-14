<?php 
require('../dbconnect.php');

if(isset($_POST['finalizar'])){
	if($_POST['finalizar'] == 'Cancelar Pedido'){
		$query = $database->prepare("UPDATE produto p
		SET quantidade_estoque = quantidade_estoque + (SELECT quantidade FROM item_pedido WHERE produto_id = p.id AND pedido_id = ".$_POST['pedido_id'].")
		WHERE EXISTS(SELECT * FROM item_pedido WHERE produto_id = p.id AND pedido_id = ".$_POST['pedido_id'].")");
			
		$query2 = $database->prepare("DELETE FROM pedido WHERE id =".$_POST['pedido_id']);

		if($query->execute() && $query2->execute()){
			header("Location: index.php?msg=cancelado");
			die();
		}
		else{
			print_r($query->errorInfo());
			print_r($query2->errorInfo());
		}

	}
	else{
		$query = $database->prepare("SELECT SUM(ip.preco_venda * ip.quantidade) as total FROM item_pedido ip INNER JOIN pedido p ON p.id = ip.pedido_id WHERE p.id =".$_POST['pedido_id']);
		if($query->execute()){
			$result = $query->fetch(PDO::FETCH_ASSOC);
			$total = isset($result['total']) ? $result['total'] : 0;
			var_dump($total);
			$query2 = $database->prepare("UPDATE pedido SET valor_total=".$total.", status='concluido', data_venda='".date('d/M/Y')."' 
				WHERE id=".$_POST['pedido_id']);
			if($query2->execute()){
				header("Location: index.php?msg=concluido");
				die();
			}
			else{
				print_r($query->errorInfo());
			}
		}
	}

}

?>