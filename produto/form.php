<?php
	$content = ob_get_contents();

	include("../index.php");

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

<script type="text/javascript">
	$(function(){
		$('input[name="produto[preco_venda]').keyup(function(){
			if (/\D/g.test(this.value)){
				this.value = this.value.replace(/\D/g, '');
		  	}
		})
	})
</script>

<div id="body">
	<header>
		<?= isset($_GET['id']) ? "Editar" : "Cadastrar" ?> Produto
	</header>
	<section>
		<div id="formDiv">
			<form action="<?= isset($_GET['id']) ? 'update.php' : 'create.php'?>" method="post">

				<?php if(isset($_GET['id'])){
					echo '<input type="hidden" name="produto[id]" value="'.$_GET['id'].'">';
				}?>

				<div class="formLine">
					<label>Nome</label>
					<input type="text" name="produto[nome]" value="<?= isset($nome) ? $nome : ''?>">
				</div>

				<div class="formLine">
					<label>Descrição</label>
					<input type="text" name="produto[descricao]" value="<?= isset($descricao) ? $descricao : ''?>">
				</div>

				<div class="formLine">
					<label>Preço</label>
					<input type="text" name="produto[preco_venda]" value="<?= isset($preco_venda) ? $preco_venda : ''?>">
				</div>

				<div class="formLine">
					<a href="index.php" id="voltar"> Voltar </a>

					<input type="submit" value="Enviar" id="submit">

				</div>

				
				
			</form>
		</div>
	</section>
</div>

		
