<?php
require('dbconnect.php');

session_start();

if(!isset($_SESSION["user_id"])){
  var_dump($_SESSION); 
  header('location: /controleEstoqueVenda/login.php');
  exit();
}

?>

<!DOCTYPE html>
<html>
<head>
  <title>Controle de estoque</title>

  <link rel="stylesheet" type="text/css" href="/controleEstoqueVenda/assets/stylesheets/font-awesome-4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="/controleEstoqueVenda/assets/stylesheets/style.css">
  <link rel="stylesheet" type="text/css" href="/controleEstoqueVenda/assets/stylesheets/select2.min.css">

  <script type="text/javascript" src="/controleEstoqueVenda/assets/javascripts/jquery-2.2.4.min.js"></script>
  <script type="text/javascript" src="/controleEstoqueVenda/assets/javascripts/jquery.masked.input.min.js"></script>
  <script type="text/javascript" src="/controleEstoqueVenda/assets/javascripts/select2.min.js"></script>

</head>

<script type="text/javascript">
	$(function(){
		$('#menuLateral a').click(function(){
	        $(this).toggleClass('active');
	        $(this).toggleClass('opened');
	        $(this).closest('li').find('ul').slideToggle();
      	})
	})
</script>

<body>

<header id="header">
  <div id="logo">
    <img src="/controleEstoqueVenda/assets/images/UFJF-600-dpi-1024x740.jpg">
  </div>
  <a href="/controleEstoqueVenda/logout.php" id="logout">Logout</a>
</header>

<div id="menuLateral" class="active">
  <ul>
    
    <li class="first">
      <a>Produtos <i class="fa fa-angle-left"></i></a>

      <ul>
        <li>
        	<a href="/controleEstoqueVenda/produto/index.php"> <i class="fa fa-book"></i> Listagem</a>
        </li>
        <li>
        	<a href="/controleEstoqueVenda/produto/form.php"> <i class="fa fa-file-o"></i> Novo produto</a>
        </li>
        <li>
          <a href="/controleEstoqueVenda/produto/compra.php"> <i class="fa fa-shopping-cart"></i> 
          Registrar Compra
          </a>
        </li>
        <li>
          <a href="/controleEstoqueVenda/produto/historico_compras.php"> <i class="fa fa-history"></i> 
          Histórico de Compras
          </a>
        </li>
      </ul>
      
    </li>
    <!---->
    <li class="first">
      <a>Fornecedor <i class="fa fa-angle-left"></i></a>

      <ul>
        <li>
          <a href="/controleEstoqueVenda/fornecedor/index.php"> <i class="fa fa-book"></i> Listagem</a>
        </li>
        <li>
          <a href="/controleEstoqueVenda/fornecedor/form.php"> <i class="fa fa-file-o"></i> Novo fornecedor</a>
        </li>
      </ul>
    
    </li>

    <li><a href="/controleEstoqueVenda/relatorio/">Relatorio</a></li>

  </ul>
</div>

<?php
	//echo $content;
?>

</body>
</html>
