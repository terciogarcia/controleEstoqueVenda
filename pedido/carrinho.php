<?php
include("../index.php");

$content = ob_get_contents();

$query = $database->prepare("SELECT * FROM pedido WHERE cliente_id = ".$_SESSION['user_id']." AND status='novo'");

if($query->execute()){
	$result = $query->fetch(PDO::FETCH_ASSOC);
	//Se não tem pedido iniciado
	if(empty($result)){
		//criar pedido
		$query = $database->prepare("INSERT INTO pedido(cliente_id,status,data_criacao) values(".$_SESSION['user_id'].",'novo', '".date('d/M/Y')."')");
		if($query->execute()){
			$id = $database->lastInsertId('pedido_id_seq');
		}
		else{
			echo print_r($query->errorInfo());
		}
	}
	else{

	}
}

?>
<script type="text/javascript">
	$(document).ready(function(){
		$('.select2').select2();

		$('#addProduto').click(function(){
			var id_produto = $('#select-produto').val();
			
			if(id_produto == ''){
				alert("Nenhum produto selecionado.");
				return;
			}

			if($('.item_id[value="'.+id_produto+.'"]').length){
				alert("Esse produto já foi adicionado.");
				return;
			}


			$.ajax({
			  url: "add_produto.php",
			  method: "GET",
			  data: { 
			  		'id_pedido' : $('input[name="pedido[id]"]').val(), 
			  		'id_produto': id_produto
			  	},
			  success: function(data){
			  	$('#tableCustom tbody').append(data);
			  }
			});
		});

	});
</script>

<div id="body">
	<header>
		Meu Carrinho
	</header>
	<section>
		<div id="formDiv">
			<form action="" method="post">
				<input type="hidden" name="pedido[id]" value="<?=$id?>">
				<div class="formLine">
					<label>Adicionar produto</label>
					<select id="select-produto" class="select2">
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
					<input type="button" id="addProduto" value="Ok" />
				</div>

				<table id="tableCustom">
					<thead>
						<tr>
							<th>Produto</th>
							<th>Quantidade</th>
							<th>Preço Unidade</th>
							<th>Preço Total</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>

			</form>
		</div>
	</section>
</div>

		

