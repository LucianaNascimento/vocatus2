<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

// conecta o banco de dados
$banco = new PDO('mysql:host=localhost;dbname=vocatus', 'root', '',
    array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

/*
1 - verificar o codigo digitado
2 - verificar se o usuario ja respondeu a chamada
*/

// 1 - verificar o codigo digitado
$comando = $banco->prepare('SELECT * from reuniao WHERE codigo_verificacao = ?');
$comando->execute(array($_REQUEST["codigo_verificacao"]));

if($registro = $comando->fetch()) {

    // 2 - verificar se o usuario ja respondeu a chamada
    $comando = $banco->prepare('SELECT * from presencas WHERE aluno_id = ? and reuniao_id = ?');
    $comando->execute(array($_REQUEST["aluno_id"], $registro["reuniao_id"]));

    if($registro2 = $comando->fetch()) {
        $resposta["status"] = 403;
        $resposta["mensagem"] = "Já existe presença para esse usuário!";         

    } else {

        $sql = "INSERT INTO presencas
        (presenca_id, aluno_id, latitude, longitude, reuniao_id)
        VALUES (NULL, ?, ?, ?, ?)";
    
        $comando = $banco->prepare($sql);
    
        if($comando->execute(array($_REQUEST["aluno_id"], $_REQUEST["latitude"],
         $_REQUEST["longitude"], $registro["reuniao_id"]))) {
    
            $resposta["status"] = 200;
            $resposta["mensagem"] = "presença cadastrada com sucesso!";
    
        } else {
            $resposta["status"] = 401;
            $resposta["mensagem"] = "Erro ao cadastrar a presença. Tente novamente!";
        }

    }
   
} else {
    $resposta["status"] = 402;
    $resposta["mensagem"] = "Codigo inválido!"; 
}

echo json_encode($resposta);
