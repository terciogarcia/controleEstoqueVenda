<?php
	$content = ob_get_contents();

	include("../index.php");

	if(isset($_GET['id'])){
		$query = $database->prepare("
			SELECT prod.nome as nome, ped.data_venda as data, ip.preco_venda as preco, ip.quantidade as quantidade FROM produto prod 
				JOIN item_pedido ip ON ip.produto_id = prod.id 
				JOIN pedido ped ON ped.id = ip.pedido_id
			WHERE ped.id = ".$_GET['id']."
		");
		if($query->execute()){
			$result = $query->fetch(PDO::FETCH_ASSOC);
			
		}

	}
?>

<script type="text/javascript">
	$(function(){
		$('#submit').click(function(e){
			window.print()
		})
	})
</script>

<style type="text/css">
	@media print {
		header#header,
		#menuLateral,
		#submit,
		#voltar{
			display: none;
		}

		div#body{
			margin: 0 auto;
		}
	}
</style>


<div id="body">
	<header>
		Nota Fiscal
	</header>
	<section>
		<div id="formDiv">
			<form action="<?= isset($_GET['id']) ? 'update.php' : 'create.php'?>" method="post">

				<?php if(isset($_GET['id'])){
					echo '<input type="hidden" name="produto[id]" value="'.$_GET['id'].'">';
				}?>

				<div class="formLine">
					<label>Produto:</label>
					<?php 
						echo $result['nome'];
					?>
				</div>

				<div class="formLine">
					<label>Data da venda:</label>
					<?php 
						echo (new DateTime($result['data']))->format('d/m/Y');
					?>
				</div>

				<div class="formLine">
					<label>Preço da venda:</label>
					<?php 
						echo $result['preco'];
					?>
				</div>

				<div class="formLine">
					<label>Quantidade:</label>
					<?php 
						echo $result['quantidade'];
					?>
				</div>

				<div class="formLine">
					<a href="index.php" id="voltar"> Voltar </a>

					<input type="button" value="imprimir" id="submit">

				</div>

			</form>
		</div>
	</section>
</div>

		
