<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

error_reporting(0);

// conecta o banco de dados
$banco = new PDO('mysql:host=localhost;dbname=vocatus', 'root', '',
    array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

// prepara uma consulta SELECT para verificar se já existe o usuario
$comando = $banco->prepare('SELECT * from reuniao WHERE reuniao_id = ?');

// passa os dados (parametros) para o SELECT
$comando->execute(array($_REQUEST["id"]));

if($registro = $comando->fetch()) {
    $resposta["status"] = 402;
    $resposta["mensagem"] = "reuniao já existe!";    
} else {
    
    $sql = "INSERT INTO reuniao
	(reuniao_id, disciplina_id, DATA, observacao, codigo_verificacao, latitude, longitude)
	VALUES (NULL, ?, STR_TO_DATE(?, '%d/%m/%Y'), ?, ?, ?, ?)";
 
    $comando = $banco->prepare($sql);

    if($comando->execute(array(  $_REQUEST["id"], $_REQUEST["data"], $_REQUEST["observacao"],
        $_REQUEST["codigo"], $_REQUEST["latitude"], $_REQUEST["longitude"]))) {

        $resposta["status"] = 200;
        $resposta["mensagem"] = "reuniao cadastrada com sucesso!";

    } else {
        $resposta["status"] = 401;
        $resposta["mensagem"] = "Erro ao cadastrar o reuniao. Tente novamente!";
    }
}

echo json_encode($resposta);
