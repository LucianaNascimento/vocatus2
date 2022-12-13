<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

try {
  $banco = new PDO('mysql:host=localhost;dbname=vocatus', 'root', '',
        array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));    

  $nome = $_POST["nome"];
  $email = $_POST["email"];
  $ra = $_POST["ra"];
  $telefone = $_POST["telefone"];
  $senha = $_POST["senha"];

  $consulta = $banco->query("SELECT * FROM usuarios WHERE email='$email'");
  if( $linha = $consulta->fetch() ) {
      $resposta["status"] = "200";
      $resposta["mensagem"] = "Já existe esse email cadastrado!";
  } else {
      $banco->query("INSERT INTO usuarios
          (nome, email, ra, telefone, senha) VALUES
          ('$nome','$email','$ra','$telefone','$senha')");

      $resposta["status"] = "100";
      $resposta["mensagem"] = "Usuário cadastrado com sucesso!";
  }
    print json_encode($resposta);
} catch (PDOException $e) {
    die("Error: " . $e-getMessage());
}

?>