<?php 
require('../dbconnect.php');
?>
<html>
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<?php
		if(isset($_GET['id'])){
			$query = $database->prepare("SELECT * from produto where id=".$_GET['id']);
			if($query->execute()){
				$result = $query->fetch(PDO::FETCH_ASSOC);
				foreach ($result as $key => $value) {
					$$key = $value;
				}
			}

		}
		
		
		?>
		<form action="<?= isset($_GET['id']) ? 'update.php' : 'create.php'?>" method="post">
			<?php if(isset($_GET['id'])){
				echo '<input type="hidden" name="produto[id]" value="'.$_GET['id'].'">';
			}?>
			<h1><?= isset($_GET['id']) ? "Editar" : "Cadastrar" ?> Produto</h1>
			Nome:
			<input type="text" name="produto[nome]" value="<?= isset($nome) ? $nome : ''?>">
			<br>
			Descrição:
			<input type="text" name="produto[descricao]" value="<?= isset($descricao) ? $descricao : ''?>">
			<br>
			Preço:
			<input type="text" name="produto[preco_venda]" value="<?= isset($preco_venda) ? $preco_venda : ''?>">
			<br>
			<input type="submit" value="Enviar">
			<button><a href="index.php"> Voltar </a></button>
		</form>
	</body>
</html>
