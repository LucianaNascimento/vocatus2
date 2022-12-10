<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

// conecta o banco de dados
$banco = new PDO('mysql:host=localhost;dbname=vocatus', 'root', '',
    array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

$arquivo = '..\\anexos\\' . date('Ymdhis') . basename($_FILES['anexo']['name']);

if (move_uploaded_file($_FILES['anexo']['tmp_name'], $arquivo)) {
    
    $sql = "INSERT INTO anexos
	(anexos_id, data, disciplina_id, arquivo)
	VALUES (NULL, now(), ?, ?)";

    $comando = $banco->prepare($sql);

    if($comando->execute(array($_REQUEST["id"], $arquivo))) {

        $resposta["status"] = 200;
        $resposta["mensagem"] = "arquivo cadastro com sucesso!";

    } else {
        $resposta["status"] = 401;
        $resposta["mensagem"] = "Erro ao cadastrar o arquivo. Tente novamente!";
    }
}else{
    $resposta["status"] = 402;
    $resposta["mensagem"] = "Erro ao enviar o arquivo!";
}

echo json_encode($resposta);
