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
		$id = $result['id'];

	}
}
?>
<script type="text/javascript">
	$(document).ready(function(){
		atualizaTotal();
		$('.select2').select2();

		$('#addProduto').click(function(){
			var id_produto = $('#select-produto').val();
			
			if(id_produto == ''){
				alert("Nenhum produto selecionado.");
				return;
			}

			if($('.item_id[value="'+id_produto+'"]').length){
				alert("Esse produto já foi adicionado.");
				return;
			}


			$.ajax({
			  url: "add_produto.php",
			  method: "GET",
			  data: { 
			  		'id_pedido' : $('input[name="pedido_id"]').val(), 
			  		'id_produto': id_produto
			  	},
			  success: function(data){
  			  	if(data == "erro"){
  			  		alert("Produto fora de estoque");
				}
				else{
				  	$('#tableCustom tbody').append(data);
				  	atualizaTotal();
			  	}
			  }
			});
		});
	});

	function atualizaTotal(){
		var total = 0;
		$('#tableCustom tr> td:nth-child(4)').each(function(){
			total+= parseFloat($(this).text());
		});
		$('#total').text(total);
	}

	function excluir(e){
		var id_produto = e.closest('tr').find('.item_id').val();
		$.ajax({
		  url: "remove_produto.php",
		  method: "GET",
		  data: { 
		  		'id_pedido' : $('input[name="pedido_id"]').val(), 
		  		'id_produto': id_produto
		  	},
		  success: function(data){
		  	if(data == "ok"){
				e.closest('tr').remove();
				atualizaTotal();
		  	}
		  }
		});
	}

	function atualizar(e, aumentar){
		var qtd = parseInt(e.siblings('span').text());
		if(aumentar==0 && qtd == 1){
			alert("Quantidade não pode ser menor que 1");
			return;
		}


		var id_produto = e.closest('tr').find('.item_id').val();
		$.ajax({
		  url: "atualizar_produto.php",
		  method: "GET",
		  data: { 
		  		'id_pedido' : $('input[name="pedido_id"]').val(), 
		  		'id_produto': id_produto,
		  		'aumentar':aumentar
		  	},
		  success: function(data){
		  	if(data == "ok"){
		  		if(aumentar){
					qtd++;
				}
				else{
					qtd--;
				}
				e.siblings('span').text(qtd);
				atualizaLinha(e);
			}

			if(data == "erro"){
		  		alert("Não há mais unidades desse produto em estoque");
			}
		  }
		});

	}

	function atualizaLinha(e){
		var preco = parseFloat(e.closest('tr').children('td:nth-child(3)').text());
		var qtd = parseFloat(e.closest('tr').find('td:nth-child(2) span').text());
		e.closest('tr').children('td:nth-child(4)').text((preco * qtd).toFixed(2));
		atualizaTotal();
	}
</script>

<div id="body">
	<header>
		Meu Carrinho
	</header>
	<section>
		<div id="formDiv">
			<form action="finalizar" method="post">
				<input type="hidden" name="pedido_id" value="<?=$id?>">
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
							<th>Remover</th>
						</tr>
					</thead>
					<tbody>
					<?php 
					$query = $database->prepare("SELECT prod.id, prod.nome, ip.quantidade, ip.preco_venda as preco, ip.preco_venda*ip.quantidade as preco_total 
						FROM item_pedido ip INNER JOIN pedido p ON p.id = ip.pedido_id INNER JOIN produto prod ON prod.id = ip.produto_id WHERE p.id = ".$id);
					if($query->execute()){
						$result = $query->fetchAll(PDO::FETCH_ASSOC);
						foreach ($result as $row) {
						?>
							<tr>
								<td>
								<input type="hidden" class="item_id" value="<?=$row['id']?>">
								<?=$row['nome']?>
								</td>
								<td>
									<span><?=$row['quantidade']?></span>
									<a href="#" onclick="atualizar($(this),1)">
										<i class="fa fa-plus"></i>
									</a>
									<a href="#" onclick="atualizar($(this),0)">
										<i class="fa fa-minus"></i>
									</a>
								</td>
								<td><?=number_format($row['preco'], 2)?></td>
								<td><?=number_format($row['preco_total'], 2)?></td>
								<td>
									<a href="#" onclick="excluir($(this))"><i class="fa fa-trash"></i></a>
								</td>
							</tr>
						<?php
						}
					}
					else{
						print_r($query->errorInfo());
					}
					?>
					</tbody>
					<tfoot>
						<tr>
							<td colspan="5">Total: R$<span id="total"></span></td>
						</tr>
					</tfoot>
				</table>

				<div class="formLine">
					<input type="submit" value="Concluir Pedido" value="concluir" name="finalizar" id="submit">
					<input type="submit" value="Cancelar Pedido" value="cancelar" name="finalizar" id="cancelar">
				</div>

			</form>
		</div>
	</section>
</div>

		

