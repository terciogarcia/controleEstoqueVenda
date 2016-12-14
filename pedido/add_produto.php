<?php
require('../dbconnect.php');

if(isset($_GET['id_pedido']) && isset($_GET['id_produto'])){
	$query = $database->prepare("SELECT * FROM produto WHERE id = ".$_GET['id_produto']);

	if($query->execute()){
		$result = $query->fetch(PDO::FETCH_ASSOC); 
		$query2 = $database->prepare("INSERT INTO item_pedido values(pedido_id,produto_id,quantidade, preco_venda) 
		VALUES(".$_GET['id_pedido'].", ".$_GET['id_produto'].", 1, ".$result['preco_venda'].")");
		$query2->execute();
		?>
		<tr>
			<td>
			<input type="hidden" name="item_pedido[id][]" class="item_id" value="<?=$result['id']?>">
			<?=$result['nome']?>
			</td>
			<td>1</td>
			<td><?=$result['preco_venda']?></td>
			<td><?=$result['preco_venda']?></td>
		</tr>
		<?php
	}
}

?>