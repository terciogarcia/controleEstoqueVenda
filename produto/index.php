<?php
require('../dbconnect.php');

?>
<html>
	<head>
		<meta charset="utf-8">
	</head>
<body>
	<a href="form.php">Novo Produto</a>
	<br>
	<table>
		<thead>
		<tr>
			<th>Nome</th>
			<th>Descrição</th>
			<th>Preço</th>
			<th>Editar</th>
		</tr>
		</thead>
		<tbody>
		<?php 
			$query = $database->prepare("SELECT * from produto");
			if($query->execute()){
				$result = $query->fetchAll(PDO::FETCH_ASSOC);
				foreach ($result as $row) {
					echo "<tr>";
					echo "<td>".$row['nome']."</td>";
					echo "<td>".$row['descricao']."</td>";
					echo "<td>".$row['preco_venda']."</td>";
					echo "<td><a href=\"form.php?id=".$row['id']."\">Editar</a></td>";
					echo "</tr>";
				}
			}
		?>
		</tbody>
	</table>
</body>
</html>
