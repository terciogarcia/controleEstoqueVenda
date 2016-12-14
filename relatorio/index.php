<?php
	$content = ob_get_contents();

	include("../index.php");

	function getProdutosEmBaixa($database){
		$query = $database->prepare("SELECT * from produto where quantidade_estoque <= 5");
		$query->execute();
		return $query;
	}

	function getRelatorioCompras($database){

		$mes = isset($_GET['mes']) ? $_GET['mes'] : 1;
		$user_id = $_SESSION['user_id'];

		$query = $database->prepare("
			SELECT prod.nome as nome, ped.data_venda as data, ped.valor_total as preco, ped.status as status FROM produto prod 
				JOIN item_pedido ip ON ip.produto_id = prod.id 
				JOIN pedido ped ON ped.id = ip.pedido_id
			WHERE ped.cliente_id = ".$user_id." AND ped.status = 'concluido' AND Extract(month from ped.data_venda) = ".$mes."
		");

		$query->execute();
		return $query;
	}
?>

<script type="text/javascript">
	$(function(){
		<?php if(isset($_GET['mes'])){ ?>
			$('#mes_pesquisa select').val(<?php echo $_GET['mes']?>)
		<?php }?>

		$('#mes_pesquisa select').on('change', function(){
			window.location.href = '/controleEstoqueVenda/relatorio/index.php?mes='+$(this).val()
		})
	})
</script>

<style type="text/css">
	#mes_pesquisa{
		margin: 0 0 15px;
	}

	#mes_pesquisa select{
		border: solid 1px #aaa;
	    padding: 4px 5px;
	    width: auto;
	    border-radius: 5px;
	}
</style>

<div id="body">
	<header>
		<?php 
			if($_SESSION['role'] == "gerente"){
				echo 'Relatório de produtos em baixa';
				$listagem = getProdutosEmBaixa($database);
			}
			else{
				echo 'Relatório de compras';
				$listagem = getRelatorioCompras($database);
			}
		?>
	</header>
	<section>
		<?php if($_SESSION['role'] == "cliente"){?>
			<div id="mes_pesquisa">
				<label>Mês desejado:</label>
				<select>
					<option value="1">Janeiro</option>
					<option value="2">Fevereiro</option>
					<option value="3">Março</option>
					<option value="4">Abril</option>
					<option value="5">Maio</option>
					<option value="6">Junho</option>
					<option value="7">Julho</option>
					<option value="8">Agosto</option>
					<option value="9">Setembro</option>
					<option value="10">Outubro</option>
					<option value="11">Novembro</option>
					<option value="12">Dezembro</option>
				</select>
			</div>
		<?php } ?>

		<table id="tableCustom">
			<thead>
				<tr>
					<?php 
					if($_SESSION['role'] == "gerente"){
						echo "<th>Nome</th><th>Descrição</th><th>Preço de venda</th><th>Quantidade em estoque</th>";
					}
					else{
						echo "<th>Produto</th><th>Data de venda</th><th>Valor</th><th>Status</th>";
					}
					?>
				</tr>
			</thead>
			<tbody>
			<!--oddloop-->
			<?php 
				if(sizeof($listagem) > 0){
					if($_SESSION['role'] == "gerente"){
						foreach ($listagem as $row) {
							echo '<tr>';
								echo "<td>".$row['nome']."</td>";
								echo "<td>".$row['descricao']."</td>";
								echo "<td>".$row['preco_venda']."</td>";
								echo "<td>".$row['quantidade_estoque']."</td>";
							echo '</tr>';
						}
					}
					else{
						foreach ($listagem as $row) {
							echo '<tr>';
								echo "<td>".$row['nome']."</td>";
								echo "<td>".(new DateTime($row['data']))->format('d/m/Y')."</td>";
								echo "<td>".$row['preco']."</td>";
								echo "<td>".$row['status']."</td>";
							echo '</tr>';
						}
					}
					
				}
			?>
			<!--oddloop-->
			</tbody>
		</table>

	</section>
</div>

