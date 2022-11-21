<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

// conecta o banco de dados
$banco = new PDO('mysql:host=localhost;dbname=vocatus', 'root', '',
    array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

// prepara uma consulta SELECT para verificar se já existe o usuario
$comando = $banco->prepare('SELECT * from anexos WHERE arquivo = ?');

// passa os dados (parametros) para o SELECT
$comando->execute(array($_REQUEST["arquivo"]));

if($registro = $comando->fetch()) {
    $resposta["status"] = 402;
    $resposta["mensagem"] = "arquivo já existe!";    
} else {
    
    $sql = "DELETE anexos
	(anexos_id, data, disciplina_id, arquivo)
	VALUES (NULL, ?, ?, ?, ? md5(?))";

    $comando = $banco->prepare($sql);

    if($comando->execute(array($_REQUEST["anexo_id"], '',
        $_REQUEST["disciplina_id"], $_REQUEST["data"], $_REQUEST["arquivo"]))) {

        $resposta["status"] = 200;
        $resposta["mensagem"] = "arquivo cadastro com sucesso!";

    } else {
        $resposta["status"] = 401;
        $resposta["mensagem"] = "Erro ao cadastrar o arquivo. Tente novamente!";
    }
}

echo json_encode($resposta);
