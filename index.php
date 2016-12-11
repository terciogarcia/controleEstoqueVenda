<?php
#require('dbconnect.php');

?>

<!DOCTYPE html>
<html>
<head>
  <title>Controle de estoque</title>

  <link rel="stylesheet" type="text/css" href="/controleEstoqueVenda/assets/stylesheets/font-awesome-4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="/controleEstoqueVenda/assets/stylesheets/style.css">

  <script type="text/javascript" src="/controleEstoqueVenda/assets/javascripts/jquery-2.2.4.min.js"></script>

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
      </ul>
      
    </li>
    <!---->
    <li class="first">
      <a>Outra coisa X <i class="fa fa-angle-left"></i></a>

      <ul>
        <li>
        	<a href="#"> <i class="fa fa-user"></i> subcoisa 1</a>
        </li>
        <li>
        	<a href="#"> <i class="fa fa-user"></i> subcoisa2</a>
        </li>
      </ul>
      
    </li>

  </ul>
</div>

<?php
	echo $content;
?>

</body>
</html>
