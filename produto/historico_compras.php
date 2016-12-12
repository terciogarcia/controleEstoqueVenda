<?php
	$content = ob_get_contents();

	include("../index.php");
?>

<div id="body">
	<header>
		Histórico de compras de produto
	</header>
	<section>

		<a href="compra.php" id="new">Registrar compra</a>

		<?php 
			if(isset($_GET['msg'])){
				$msg = "Compra de produto registrada com sucesso.";
				echo '<div id="notice">'.$msg.'<i class="fa fa-check"></i></div>';
			}
		?>

		<table id="tableCustom">
			<thead>
				<tr>
					<th>Produto</th>
					<th>Fornecedor</th>
					<th>Preço de Compra</th>
					<th>Quantidade</th>
				</tr>
			</thead>
			<tbody>
			<!--oddloop-->
			<?php 
				$query = $database->prepare("SELECT pf.*, cast(preco_compra AS money),  p.nome as pnome, f.nome as fnome from produto_fornecedor pf INNER JOIN fornecedor f ON f.id = pf.fornecedor_id INNER JOIN produto p ON p.id = pf.produto_id");
				if($query->execute()){
					$result = $query->fetchAll(PDO::FETCH_ASSOC);
					foreach ($result as $row) {
						echo '<tr>';
							echo "<td>".$row['pnome']."</td>";
							echo "<td>".$row['fnome']."</td>";
							echo "<td>".$row['preco_compra']."</td>";
							echo "<td>".$row['quantidade_compra']."</td>";
						echo '</tr>';
					}
				}
			?>
			<!--oddloop-->
			</tbody>
		</table>

	</section>
</div>