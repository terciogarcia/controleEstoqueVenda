<?php
	$content = ob_get_contents();

	include("../index.php");
?>

<div id="body">
	<header>
		Histórico de pedidos
	</header>
	<section>

		<a href="carrinho.php" id="new">Carrinho</a>

		<?php 
			if(isset($_GET['msg'])){
				/*$msg = "Compra de produto registrada com sucesso.";
				echo '<div id="notice">'.$msg.'<i class="fa fa-check"></i></div>';*/
			}
		?>

		<table id="tableCustom">
			<thead>
				<tr>
					<th>Data</th>
					<th>Valor Total</th>
				</tr>
			</thead>
			<tbody>
			<!--oddloop-->
			<?php 
				$query = $database->prepare("SELECT to_char(data_venda, 'DD/MM/YYYY') as data_venda , cast(valor_total as money) FROM pedido WHERE status='concluido' AND cliente_id=".$_SESSION['user_id']." ORDER BY data_criacao DESC");
				if($query->execute()){
					$result = $query->fetchAll(PDO::FETCH_ASSOC);
					foreach ($result as $row) {
						echo '<tr>';
							echo "<td>".$row['data_venda']."</td>";
							echo "<td>".$row['valor_total']."</td>";
						echo '</tr>';
					}
				}
			?>
			<!--oddloop-->
			</tbody>
		</table>

	</section>
</div>