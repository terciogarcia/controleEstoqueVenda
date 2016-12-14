<?php 
require('../dbconnect.php');

if(isset($_GET['id'])){
	$database->beginTransaction(); 
	$deleteE = $database->prepare("DELETE FROM endereco e USING fornecedor f  WHERE e.id = f.endereco_id AND f.id = ".$_GET['id']);
	$deleteF = $database->prepare("DELETE FROM fornecedor f WHERE f.id = ".$_GET['id']." ;");
	if($deleteE->execute() && $deleteF->execute()){
		$database->commit();
		header("Location: index.php?msg=delete");
		die();
	}	
	else{
		$database->rollback();
		header("Location: index.php?msg=error");
		die();
	}
}
?>