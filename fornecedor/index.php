<?php
	$content = ob_get_contents();

	include("../index.php");

	function getEndereco(&$row){
		$endereco = $row['rua']. ' '. $row['numero'].'/'.$row['complemento'];
		$endereco.= ', '.$row['bairro'];
		$endereco.= '<br>'.$row['cidade']. ' - '. $row['estado'];
		$endereco.= '<br>CEP: '.$row['cep'].' | Referencia: '.$row['ponto_referencia'];
		return $endereco;
	}
?>

<script type="text/javascript">
	$(function(){
		$('.excluir').click(function(e){
			if(!confirm("Tem certeza que deseja excluir esse fornecedor?")){
				e.preventDefault();
			}
		})
	})
</script>

<div id="body">
	<header>
		Lista de fornecedores
	</header>
	<section>

		<a href="form.php" id="new">Novo fornecedor</a>

		<?php 
			if(isset($_GET['msg'])){
				$msg;
				switch ($_GET['msg']) {
					case 'delete':
						$msg = "Fornecedor excluido com sucesso.";
						echo '<div id="notice" class="error">'.$msg.'<i class="fa fa-times"></i></div>';
						break;
					case 'create':
						$msg = "Fornecedor criado com sucesso.";
						echo '<div id="notice">'.$msg.'<i class="fa fa-check"></i></div>';
						break;
					case 'update':
						$msg = "Fornecedor atualizado com sucesso.";
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
					<th>CNPJ</th>
					<th>Endereço</th>
					<th>Email</th>
					<th>Editar</th>
					<th>Excluir</th>
				</tr>
			</thead>
			<tbody>
			<!--oddloop-->
			<?php 
				$query = $database->prepare("SELECT * from fornecedor f INNER JOIN endereco e ON e.id = f.endereco_id");
				if($query->execute()){
					$result = $query->fetchAll(PDO::FETCH_NAMED);
					foreach ($result as $row) {
						echo '<tr>';
							echo "<td>".$row['nome']."</td>";
							echo "<td>".$row['cnpj']."</td>";
							echo "<td>".getEndereco($row)."</td>";
							echo "<td>".$row['email']."</td>";
							echo '<td><a href="form.php?id='.$row['id'][0].'"> <i class="fa fa-edit"></i></a></td>';
							echo '<td><i class="fa fa-trash"></i><a href="delete.php?id='.$row['id'][0].'" class="excluir"> </a></td>';
						echo '</tr>';
					}
				}
			?>
			<!--oddloop-->
			</tbody>
		</table>

	</section>
</div>

