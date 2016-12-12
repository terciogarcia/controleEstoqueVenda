<?php
	require('../dbconnect.php');

	$content = ob_get_contents();

	include("../index.php");
?>

<script type="text/javascript">
	$(function(){
		$('.excluir').click(function(e){
			if(!confirm("Tem certeza que deseja excluir essa conta?")){
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
				echo '<div id="notice">'.$_GET['msg'].'<i class="fa fa-check"></i></div>';
			}
		?>

		<table id="tableCustom">
			<thead>
				<tr>
					<th>Nome</th>
					<th>Descrição</th>
					<th>Preço</th>
					<th>Editar</th>
					<th>Excluir</th>
				</tr>
			</thead>
			<tbody>
			<!--oddloop-->
			<?php 
				$query = $database->prepare("SELECT * from produto");
				if($query->execute()){
					$result = $query->fetchAll(PDO::FETCH_ASSOC);
					foreach ($result as $row) {
						echo '<tr>';
							echo "<td>".$row['nome']."</td>";
							echo "<td>".$row['descricao']."</td>";
							echo "<td>".$row['preco_venda']."</td>";
							echo '<td><a href="form.php?id='.$row['id'].'"> <i class="fa fa-edit"></i></a></td>';
							echo '<td><i class="fa fa-trash"></i><a href="excluir.php?id='.$row['id'].'" class="excluir"> </a></td>';
						echo '</tr>';
					}
				}
			?>
			<!--oddloop-->
			</tbody>
		</table>

	</section>
</div>