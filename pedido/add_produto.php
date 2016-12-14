<?php
require('../dbconnect.php');

if(isset($_GET['id_pedido']) && isset($_GET['id_produto'])){
	$query = $database->prepare("SELECT quantidade_estoque FROM produto WHERE id = ".$_GET['id_produto']);
	$query->execute();
	$row = $query->fetch(PDO::FETCH_ASSOC); 
	if($row['quantidade_estoque'] > 0){
		$query = $database->prepare("SELECT * FROM produto WHERE id = ".$_GET['id_produto']);
		$query2 = $database->prepare("UPDATE produto SET quantidade_estoque = quantidade_estoque-1 WHERE id = ".$_GET['id_produto']);

		if($query->execute() && $query2->execute()){
			$row = $query->fetch(PDO::FETCH_ASSOC); 
			$query2 = $database->prepare("INSERT INTO item_pedido(pedido_id,produto_id,quantidade, preco_venda) 
			VALUES(".$_GET['id_pedido'].", ".$_GET['id_produto'].", 1, ".$row['preco_venda'].")");
			if(!$query2->execute()){
				print_r($query2->errorInfo());
			}
			?>
			<tr>
				<td>
				<input type="hidden" class="item_id" value="<?=$row['id']?>">
				<?=$row['nome']?>
				</td>
				<td>
					<span>1</span>
					<a href="#" onclick="atualizar($(this),1)">
						<i class="fa fa-plus"></i>
					</a>
					<a href="#" onclick="atualizar($(this),0)">
						<i class="fa fa-minus"></i>
					</a>
				</td>
				<td><?=number_format($row['preco_venda'], 2)?></td>
				<td><?=number_format($row['preco_venda'], 2)?></td>
				<td>
					<a href="#" onclick="excluir($(this))"><i class="fa fa-trash"></i></a>
				</td>
			</tr>
			<?php
		}
	}
	else{
		echo "erro";
	}
}

?>