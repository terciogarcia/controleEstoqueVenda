<?php
	$content = ob_get_contents();

	include("../index.php");

	if(isset($_POST['produto_fornecedor'])){
		$data = $_POST['produto_fornecedor'];
		$query = $database->prepare("insert into produto_fornecedor(produto_id, fornecedor_id, preco_compra, quantidade_compra) values(:produto_id, :fornecedor_id, :preco_compra, :quantidade_compra)");

		foreach ($data as $key => $value) {
	    	$query->bindValue(':'.$key, $value, PDO::PARAM_STR);
		}
		if($query->execute()){
			header("Location: historico_compras.php?msg=compra");
			die();
		}	
		else{
			echo print_r($query->errorInfo());
		}

	}
?>

<script type="text/javascript">
	$(function(){
		$('.select2').select2();
	})
</script>

<div id="body">
	<header>
		Registrar compra de produto
	</header>
	<section>
		<div id="formDiv">
			<form action="" method="post">
				<div class="formLine">
					<label>Produto</label>
					<select name="produto_fornecedor[produto_id]" class="select2">
						<option value="">Selecione o produto...</option>
						<?php
						$query = $database->prepare("SELECT * from produto");
						if($query->execute()){
							$result = $query->fetchAll(PDO::FETCH_ASSOC);
							foreach ($result as $row) {
								echo '<option value="'.$row['id'].'">'.$row['nome'].'</option>';
							}
						}?>
					</select>
				</div>

				<div class="formLine">
					<label>Fornecedor</label>
					<select name="produto_fornecedor[fornecedor_id]" class="select2">
						<option value="">Selecione o fornecedor...</option>
						<?php
						$query = $database->prepare("SELECT * from fornecedor");
						if($query->execute()){
							$result = $query->fetchAll(PDO::FETCH_ASSOC);
							foreach ($result as $row) {
								echo '<option value="'.$row['id'].'">'.$row['nome'].'</option>';
							}
						}?>
					</select>
				</div>

				<div class="formLine">
					<label>Preço</label>
					<input type="text" name="produto_fornecedor[preco_compra]">
				</div>

				<div class="formLine">
					<label>Quantidade</label>
					<input type="text" name="produto_fornecedor[quantidade_compra]">
				</div>

				<div class="formLine">
					<a href="index.php" id="voltar"> Voltar </a>

					<input type="submit" value="Enviar" id="submit">

				</div>
	
			</form>
		</div>
	</section>
</div>

		
