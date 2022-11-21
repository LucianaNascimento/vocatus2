<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

error_reporting(E_ERROR);

// conecta o banco de dados
$banco = new PDO('mysql:host=localhost;dbname=vocatus', 'root', '',
    array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
// prepara uma consulta SELECT para verificar se já existe o usuario
$comando = $banco->prepare('SELECT * from usuarios WHERE email = ?');

// passa os dados (parametros) para o SELECT
$comando->execute(array($_REQUEST["email"]));

if($registro = $comando->fetch()) {
    $resposta["status"] = 402;
    $resposta["mensagem"] = "Usuário já existe!";    
} else {

        $sql = "REPLACE INTO usuario
        (email, telefone, senha, foto, ra, nome, usuario_Id)
        VALUES (?, ?, ?, ?, ?, ?, ?)";
    
        $comando = $banco->prepare($sql);
    
        if($comando->execute(array($_REQUEST["id"], $_REQUEST["nome"], $arquivo, $_REQUEST["telefone"], 
            $_REQUEST["email"], $_REQUEST["senha"], $_REQUEST["foto"]))) {
    
            $resposta["status"] = 200;
            $resposta["mensagem"] = "Produto cadastro com sucesso!";
    
        } else {
            $resposta["status"] = 401;
            $resposta["mensagem"] = "Erro ao cadastrar o produto. Tente novamente!";
        }
    
    } 

echo json_encode($resposta);

