<?php
require('dbconnect.php');
$senhaIncorreta = false;

if(isset($_POST['usuario'])){
  $dados = $_POST['usuario'];
  $query = $database->prepare("SELECT * from usuario u INNER JOIN gerente g ON g.id = u.id WHERE u.login=:login AND u.senha=:senha");
  $query->bindValue(':login', $dados['login'], PDO::PARAM_STR);
  $query->bindValue(':senha', $dados['senha'], PDO::PARAM_STR);

  if($query->execute()){
    $result = $query->fetch(PDO::FETCH_ASSOC);
    if(empty($result)){
      $query = $database->prepare("SELECT * from usuario u INNER JOIN cliente c ON c.id = u.id WHERE u.login=:login AND u.senha=:senha");
      $query->bindValue(':login', $dados['login'], PDO::PARAM_STR);
      $query->bindValue(':senha', $dados['senha'], PDO::PARAM_STR);
      if($query->execute()){
        $result = $query->fetch(PDO::FETCH_ASSOC);
        if(!empty($result)){
          session_start();
          $_SESSION['user_id'] = $result ['id'];
          $_SESSION['role'] = "cliente";
          header("Location: index.php");
          exit();
        }
        //SENHA INCORRETA
        $senhaIncorreta = true;
      }
    }
    else{
      session_start();
      $_SESSION['user_id'] = $result ['id'];
      $_SESSION['role'] = "gerente";
      header("Location: index.php");
      exit();
    }
  }
}

?>

<!DOCTYPE html>
<html>
<head>
  <title>Controle de estoque - login</title>
</head>
<link rel="stylesheet" type="text/css" href="/controleEstoqueVenda/assets/stylesheets/style.css">
<style type="text/css">
  body{
    background: #f1f1f1;
  }
  #login{
    width: 300px;
    background: #fff;
    margin: 120px auto 0;
    border-radius: 8px;
    padding: 0 0 20px 0;
  }

  #login h1{
    background: #2d7298;
    color: #fff;
    text-align: center;
    font-size: 20px;
    padding: 10px 0;
    font-weight: normal;
    border-top-left-radius: 8px;
    border-top-right-radius: 8px;
  }

  #login div{
    padding: 0 10px;
    margin: 10px 0;
  }

  #login div input[type="text"],
  #login div input[type="password"]{
    width: 100%;
    box-sizing: border-box;
    border: solid 1px #aaa;
    padding: 7px 10px;
    color: #797979;
    border-radius: 5px;
  }

  #login input[type="submit"]{
    margin: 18px auto 0;
    display: table;
    background: #268e3c;
    border: solid 1px #268e3c;
    color: #fff;
    padding: 6px 115px;
    font-size: 16px;
    border-radius: 6px;
    cursor: pointer;
    transition: 0.4s;
  }

  #login input[type="submit"]:hover{
    background: #1c6d2d;
  }    
</style>

<body>
  <div id="login">
    <h1>Controle de Estoque e Vendas</h1>

    <form action="" method="POST">
        <div>
          <input type="text" placeholder="Login" name="usuario[login]">
        </div>

        <div>
          <input type="password" placeholder="Senha" name="usuario[senha]">
        </div>

        <input type="submit" value="Enviar">
    </form>
    <?php if($senhaIncorreta){?>
      <div style="color: #f00">Erro: Login ou senha está incorreto.</div>
    <?php } ?>
  </div>

</body>
</html>
