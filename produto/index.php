<?php
	$content = ob_get_contents();

	include("../index.php");
?>

<script type="text/javascript">
	$(function(){
		$('.excluir').click(function(e){
			if(!confirm("Tem certeza que deseja excluir esse produto?")){
				e.preventDefault();
			}
		})
	})
</script>

<div id="body">
	<header>
		Lista de produtos
	</header>
	<section>

		<a href="form.php" id="new">Novo produto</a>

		<?php 
			if(isset($_GET['msg'])){
				$msg;
				switch ($_GET['msg']) {
					case 'delete':
						$msg = "Produto excluido com sucesso.";
						echo '<div id="notice" class="error">'.$msg.'<i class="fa fa-times"></i></div>';
						break;
					case 'create':
						$msg = "Produto criado com sucesso.";
						echo '<div id="notice">'.$msg.'<i class="fa fa-check"></i></div>';
						break;
					case 'update':
						$msg = "Produto atualizado com sucesso.";
						echo '<div id="notice">'.$msg.'<i class="fa fa-check"></i></div>';
						break;
					default:
						break;
				}
			}
		?>

		<table id="tableCustom">
			<thead>
				<tr>
					<th>Nome</th>
					<th>Descrição</th>
					<th>Preço</th>
					<th>Quantidade em Estoque</th>
					<th>Editar</th>
					<th>Excluir</th>
				</tr>
			</thead>
			<tbody>
			<!--oddloop-->
			<?php 
				$query = $database->prepare("SELECT *, cast(preco_venda AS money) from produto");
				if($query->execute()){
					$result = $query->fetchAll(PDO::FETCH_ASSOC);
					foreach ($result as $row) {
						echo '<tr>';
							echo "<td>".$row['nome']."</td>";
							echo "<td>".$row['descricao']."</td>";
							echo "<td>".$row['preco_venda']."</td>";
							echo "<td>".$row['quantidade_estoque']."</td>";
							echo '<td><a href="form.php?id='.$row['id'].'"> <i class="fa fa-edit"></i></a></td>';
							echo '<td><i class="fa fa-trash"></i><a href="delete.php?id='.$row['id'].'" class="excluir"> </a></td>';
						echo '</tr>';
					}
				}
			?>
			<!--oddloop-->
			</tbody>
		</table>

	</section>
</div>