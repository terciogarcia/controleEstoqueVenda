<?php 
require('../dbconnect.php');

if(isset($_GET['id'])){
	$query = $database->prepare("delete from produto where id=".$_GET['id']);
    echo $query->queryString;
	if($query->execute()){
		echo "Produto atualizado que alegria";
		echo '<br><a href="index.php">Voltar</a>';
	}	
	else{
		echo print_r($query->errorInfo());
	}
}
?>