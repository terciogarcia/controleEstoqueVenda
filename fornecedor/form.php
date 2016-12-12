<?php
	$content = ob_get_contents();

	include("../index.php");

	if(isset($_GET['id'])){
		$query = $database->prepare("SELECT * from fornecedor f INNER JOIN endereco e ON e.id = f.endereco_id WHERE f.id=".$_GET['id']);
		if($query->execute()){
			$result = $query->fetch(PDO::FETCH_ASSOC);
			foreach ($result as $key => $value) {
				$$key = $value;
			}
		}

	}
?>

<div id="body">
	<header>
		<?= isset($_GET['id']) ? "Editar" : "Cadastrar" ?> Fornecedor
	</header>
	<section>
		<div id="formDiv">
			<form action="<?= isset($_GET['id']) ? 'update.php' : 'create.php'?>" method="post">

				<?php if(isset($_GET['id'])){
					echo '<input type="hidden" name="fornecedor[id]" value="'.$_GET['id'].'">';
					if(isset($endereco_id)){
						echo '<input type="hidden" name="endereco[id]" value="'. $endereco_id .'">';
					}
				}?>


				<div class="formLine">
					<label>Nome</label>
					<input type="text" name="fornecedor[nome]" value="<?= isset($nome) ? $nome : ''?>">
				</div>

				<div class="formLine">
					<label>CNPJ</label>
					<input type="text" name="fornecedor[cnpj]" value="<?= isset($cnpj) ? $cnpj : ''?>">
				</div>

				<div class="formLine">
					<label>Email</label>
					<input type="text" name="fornecedor[email]" value="<?= isset($email) ? $email : ''?>">
				</div>
				
			    <h3>Endereço</h3>

				<div class="formLine">
					<label>Rua</label>
					<input type="text" name="endereco[rua]" value="<?= isset($rua) ? $rua : ''?>">
				</div>

				<div class="formLine">
					<label>Bairro</label>
					<input type="text" name="endereco[bairro]" value="<?= isset($bairro) ? $bairro : ''?>">
				</div>

				<div class="formLine">
					<label>Cidade</label>
					<input type="text" name="endereco[cidade]" value="<?= isset($cidade) ? $cidade : ''?>">
				</div>

				<div class="formLine">
					<label>Estado</label>
					<input type="text" name="endereco[estado]" value="<?= isset($estado) ? $estado : ''?>">
				</div>

				<div class="formLine">
					<label>Numero</label>
					<input type="text" name="endereco[numero]" value="<?= isset($numero) ? $numero : ''?>">
				</div>

				<div class="formLine">
					<label>CEP</label>
					<input type="text" name="endereco[cep]" value="<?= isset($cep) ? $cep : ''?>">
				</div>

				<div class="formLine">
					<label>Ponto Referência</label>
					<input type="text" name="endereco[ponto_referencia]" value="<?= isset($ponto_referencia) ? $ponto_referencia : ''?>">
				</div>

				<div class="formLine">
					<label>Complemento</label>
					<input type="text" name="endereco[complemento]" value="<?= isset($complemento) ? $complemento : ''?>">
				</div>

				<div class="formLine">
					<a href="index.php" id="voltar"> Voltar </a>

					<input type="submit" value="Enviar" id="submit">

				</div>		
				
			</form>
		</div>
	</section>
</div>

		
