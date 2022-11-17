<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

error_reporting(E_ERROR);

// conecta o banco de dados
$banco = new PDO('mysql:host=localhost;dbname=vocatus', 'root', '',
    array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

 // prepara uma consulta SELECT para verificar se já existe o usuario
$comando = $banco->prepare('SELECT * from reuniao WHERE aula_id = ?');

// passa os dados (parametros) para o SELECT
$comando->execute(array($_REQUEST["aula_id"]));

if($registro = $comando->fetch()) {
    $resposta["status"] = 402;
    $resposta["mensagem"] = "reuniao já existe!";    
} else {

        $sql = "REPLACE INTO reuniao
        (reuniao_id, data, disciplina_id, codigo_verificacao, latitude, logitude, observacao)
        VALUES (?, ?, ?, ?, ?, ?, ?)";
    
        $comando = $banco->prepare($sql);
    
        if($comando->execute(array($_REQUEST["id"], $_REQUEST["disciplina"], $arquivo, $_REQUEST["codigo"], 
            $_REQUEST["latitude"], $_REQUEST["longitude"], $_REQUEST["observacao"] , , $_REQUEST["data"]))) {
    
            $resposta["status"] = 200;
            $resposta["mensagem"] = "Produto cadastro com sucesso!";
    
        } else {
            $resposta["status"] = 401;
            $resposta["mensagem"] = "Erro ao cadastrar o produto. Tente novamente!";
        }
    
    } 

echo json_encode($resposta);

