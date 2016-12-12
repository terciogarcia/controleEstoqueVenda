<?php
	$content = ob_get_contents();

	include("../index.php");

	if(isset($_POST['produto_fornecedor'])){
		$database->beginTransaction(); 

		$data = $_POST['produto_fornecedor'];
		$query = $database->prepare("INSERT INTO produto_fornecedor(produto_id, fornecedor_id, preco_compra, quantidade_compra) VALUES(:produto_id, :fornecedor_id, :preco_compra, :quantidade_compra)");

		$query2 = $database->prepare("UPDATE produto SET quantidade_estoque = quantidade_estoque + :quantidade_compra WHERE id = :produto_id");
    	$query2->bindValue(':quantidade_compra', $data['quantidade_compra'], PDO::PARAM_STR);
    	$query2->bindValue(':produto_id', $data['produto_id'], PDO::PARAM_STR);

		foreach ($data as $key => $value) {
	    	$query->bindValue(':'.$key, $value, PDO::PARAM_STR);
		}
		if($query->execute() && $query2->execute()){
			$database->commit();
			header("Location: historico_compras.php?msg=compra");
			die();
		}	
		else{
			$database->rollBack();
			echo print_r($query->errorInfo());
		}

	}
?>



<script type="text/javascript">
	$(function(){
		$('.select2').select2();

		$('input[name="produto_fornecedor[preco_compra]').keyup(function(e){

			valor = $(this).val().replace(',', '.')

			if(!(!isNaN(parseFloat(valor)) && isFinite(valor)))
		    {
		       $(this).val('');
		    }
		    else{
		    	$(this).val(valor);
		    }
		});

		$('input[name="produto_fornecedor[quantidade_compra]').keyup(function(e){
		  if (/\D/g.test(this.value))
		  {
		    // Filter non-digits from input value.
		    this.value = this.value.replace(/\D/g, '');
		  }
		});
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
					<a href="historico_compras.php" id="voltar"> Voltar </a>

					<input type="submit" value="Enviar" id="submit">

				</div>
	
			</form>
		</div>
	</section>
</div>

		
