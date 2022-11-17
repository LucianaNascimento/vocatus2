<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

// conecta o banco de dados
$banco = new PDO('mysql:host=localhost;dbname=vocatus', 'root', '',
    array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

// prepara uma consulta SELECT para verificar se já existe o usuario
$comando = $banco->prepare('SELECT * from disciplina WHERE disciplina_id = ?');

// passa os dados (parametros) para o SELECT
$comando->execute(array($_REQUEST["disciplina"]));

if($registro = $comando->fetch()) {
    $sql = "DELETE FROM disciplina WHERE disciplina_id = ?";
	 
    $comando = $banco->prepare($sql);

    if($comando->execute(array($_REQUEST["disciplina"] ))) { 

        $resposta["status"] = 200;
        $resposta["mensagem"] = "disciplina excluida com sucesso!";

    } else {
        $resposta["status"] = 401;
        $resposta["mensagem"] = "Erro ao excluir a disciplina. Tente novamente!";
    }
} else {
    $resposta["status"] = 402;
    $resposta["mensagem"] = "disciplina não existe!";     
    
}

echo json_encode($resposta);
