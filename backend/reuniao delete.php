<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

// conecta o banco de dados
$banco = new PDO('mysql:host=localhost;dbname=vocatus', 'root', '',
    array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

// prepara uma consulta SELECT para verificar se já existe o usuario
$comando = $banco->prepare('SELECT * from reuniao WHERE reuniao_id = ?');

// passa os dados (parametros) para o SELECT
$comando->execute(array($_REQUEST["reuniao_id"]));

if($registro = $comando->fetch()) {
    $resposta["status"] = 402;
    $resposta["mensagem"] = "reuniao já existe!";    
} else {
    
    $sql = "DELETE reuniao
	(disciplina_id, reuniao_id, latitude, logintude, data, codigo_verificacao, observacao)
	VALUES (NULL, ?, ?, ?, ?, ?, ?, ? md5(?))";

    $comando = $banco->prepare($sql);

    if($comando->execute(array($_REQUEST["disciplina_id"], '',
        $_REQUEST["aula"], $_REQUEST["latitude"], $_REQUEST["longitude"],
        $_REQUEST["data"], $_REQUEST["codigo"] , $_REQUEST["observacao"], , $_REQUEST["reuniao_id"]))) {

        $resposta["status"] = 200;
        $resposta["mensagem"] = "reuniao cadastro com sucesso!";

    } else {
        $resposta["status"] = 401;
        $resposta["mensagem"] = "Erro ao cadastrar o reuniao. Tente novamente!";
    }
}

echo json_encode($resposta);
