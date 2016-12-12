<?php 
require('../dbconnect.php');

if(isset($_GET['id'])){
	$query = $database->prepare("delete from produto where id=".$_GET['id']);
	if($query->execute()){
		header("Location: index.php?msg=delete");
		die();
	}	
	else{
		echo print_r($query->errorInfo());
	}
}
?>