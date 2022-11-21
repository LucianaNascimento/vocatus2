<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

// conecta o banco de dados
$banco = new PDO('mysql:host=localhost;dbname=vocatus', 'root', '',
    array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

// prepara uma consulta SELECT para verificar se já existe o usuario
$comando = $banco->prepare('SELECT * from disciplina WHERE disciplina_id = ?');

// passa os dados (parametros) para o SELECT
$comando->execute(array($_REQUEST["disciplina_id"]));

if($registro = $comando->fetch()) {
    $resposta["status"] = 402;
    $resposta["mensagem"] = "disicplina já existe!";    
} else {
    
    $sql = "DELETE disciplina
	(disciplina_id, nome, qtd_aulas, professor_id, observacao, data_conclusao)
	VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, md5(?))";

    $comando = $banco->prepare($sql);

    if($comando->execute(array($_REQUEST["nome"], '',
        $_REQUEST["aulas"], $_REQUEST["professor"], $_REQUEST["observacao"],  $_REQUEST["data"] ,  $_REQUEST["id"]))) {

        $resposta["status"] = 200;
        $resposta["mensagem"] = "disicplina cadastrado com sucesso!";

    } else {
        $resposta["status"] = 401;
        $resposta["mensagem"] = "Erro ao cadastrar o disicplina. Tente novamente!";
    }
}

echo json_encode($resposta);
