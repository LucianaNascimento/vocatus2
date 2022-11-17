<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

//error_reporting(E_ERROR);

// conecta o banco de dados
$banco = new PDO('mysql:host=localhost;dbname=vocatus', 'root', '',
    array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

 // prepara uma consulta SELECT para verificar se já existe o usuario
 $comando = $banco->prepare('SELECT * from disciplina WHERE disciplina_id = ?');

// passa os dados (parametros) para o SELECT
$comando->execute(array($_REQUEST["id"]));

if($registro = $comando->fetch()) {
    $sql = "REPLACE INTO disciplina
        (disciplina_id, nome, qtd_aulas, professor_id, observacao, data_conclusao)
	VALUES (?, ?, ?, ?, ?, ?)";
    
        $comando = $banco->prepare($sql);
} 

if($comando->execute(array($_REQUEST["id"], $_REQUEST["nome"],
$_REQUEST["aulas"], $_REQUEST["professor"], $_REQUEST["observacao"],  $_REQUEST["data"] ))) {
    
            $resposta["status"] = 200;
            $resposta["mensagem"] = "reunião editada com sucesso!"; 
    
        } else {
            $resposta["status"] = 401;
            $resposta["mensagem"] = "Erro ao cadastrar a reunião. Tente novamente!";
        }
    
echo json_encode($resposta);