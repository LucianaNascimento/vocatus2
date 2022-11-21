<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

// conecta o banco de dados
$banco = new PDO('mysql:host=localhost;dbname=vocatus', 'root', '',
    array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

// prepara uma consulta SELECT para verificar se já existe o usuario
$comando = $banco->prepare('SELECT * from reuniao WHERE reuniao_id = ?');

// passa os dados (parametros) para o SELECT
$comando->execute(array($_REQUEST["reuniao"]));

if($registro = $comando->fetch()) {
    $sql = "DELETE FROM reuniao WHERE reuniao_id = ?";
	 
    $comando = $banco->prepare($sql);

    if($comando->execute(array($_REQUEST["reuniao"] ))) { 

        $resposta["status"] = 200;
        $resposta["mensagem"] = "reuniao excluida com sucesso!";

    } else {
        $resposta["status"] = 401;
        $resposta["mensagem"] = "Erro ao excluir a reuniao. Tente novamente!";
    }
} else {
    $resposta["status"] = 402;
    $resposta["mensagem"] = "reuniao não existe!";     
    
}

echo json_encode($resposta);
