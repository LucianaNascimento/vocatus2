<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

// conecta o banco de dados
$banco = new PDO('mysql:host=localhost;dbname=vocatus', 'root', '',
    array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

// prepara uma consulta SELECT
$comando = $banco->prepare('SELECT * from usuarios WHERE email = ? AND senha = ?');


// passa os dados (parametros) para o SELECT
$comando->execute(array($_REQUEST["email"], $_REQUEST["senha"]));

if($registro = $comando->fetch()) {
    $resposta["status"] = 200;
    $resposta["mensagem"] = "Bem vindo {$registro["nome"]}!";
    $resposta["telefone"] = $registro["telefone"];
    $resposta["ra"] = $registro["ra"]; 
    $resposta["usuario_id"] = $registro["usuario_id"]; 
} else {
    $resposta["status"] = 401;
    $resposta["mensagem"] = "Acesso negado!";
}

echo json_encode($resposta);