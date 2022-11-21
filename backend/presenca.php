<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

// conecta o banco de dados
$banco = new PDO('mysql:host=localhost;dbname=vocatus', 'root', '',
    array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

// prepara uma consulta SELECT para verificar se já existe o usuario
$comando = $banco->prepare('SELECT * from presencas WHERE presenca_id = ?');

// passa os dados (parametros) para o SELECT
$comando->execute(array($_REQUEST["presenca"]));

if($registro = $comando->fetch()) {
    $resposta["status"] = 402;
    $resposta["mensagem"] = "presença já existente!";    
} else {
    
    $sql = "INSERT INTO presencas
	(presenca_id, aluno_id, latitude, longitude)
	VALUES (NULL, ?, ?, ?)";

    $comando = $banco->prepare($sql);

    if($comando->execute(array($_REQUEST["aluno"], $_REQUEST["latitude"],
     $_REQUEST["longitude"]))) {

        $resposta["status"] = 200;
        $resposta["mensagem"] = "presença cadastro com sucesso!";

    } else {
        $resposta["status"] = 401;
        $resposta["mensagem"] = "Erro ao cadastrar a presença. Tente novamente!";
    }
}

echo json_encode($resposta);
