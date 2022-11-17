<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

error_reporting(E_ERROR);

// conecta o banco de dados
$banco = new PDO('mysql:host=localhost;dbname=vocatus', 'root', '',
    array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
// prepara uma consulta SELECT para verificar se já existe o usuario
$comando = $banco->prepare('SELECT * from disciplina WHERE nome = ?');

// passa os dados (parametros) para o SELECT
$comando->execute(array($_REQUEST["nome"]));

if($registro = $comando->fetch()) {
    $resposta["status"] = 402;
    $resposta["mensagem"] = "disicplina já existe!";    
} else {
       $sql = "REPLACE INTO disciplina
        (disciplina_id, nome, qtd_reuniao, professor_id, observacao, data_conclusao)
        VALUES (?, ?, ?, ?, ?, ?)";
    
        $comando = $banco->prepare($sql);
    
        if($comando->execute(array($_REQUEST["id"], $_REQUEST["nome"], $arquivo, $_REQUEST["reuniao"], 
            $_REQUEST["professor"], $_REQUEST["observacao"], $_REQUEST["data"]))) {
    
            $resposta["status"] = 200;
            $resposta["mensagem"] = "disicplina cadastrada com sucesso!";
    
        } else {
            $resposta["status"] = 401;
            $resposta["mensagem"] = "Erro ao cadastrar a disicplina. Tente novamente!";
        }
    
    }

echo json_encode($resposta);

