<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

error_reporting(E_ERROR);

// conecta o banco de dados
$banco = new PDO('mysql:host=localhost;dbname=vocatus', 'root', '',
    array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));


    $arquivo = 'fotos\\' . date('Ymdhis') . basename($_FILES['anexo']['name']);
    
    if (move_uploaded_file($_FILES['anexo']['tmp_name'], $arquivo)) {

        $sql = "REPLACE INTO presencas
        (anexos_id, data, disciplina_id, arquivo)
        VALUES (?, ?, ?, ?)";
    
        $comando = $banco->prepare($sql);
    
        if($comando->execute(array($_REQUEST["anexos_id"], $_REQUEST["data"], 
        $arquivo, $_REQUEST["disciplina_id"], $_REQUEST["arquivo"]))) {
    
            $resposta["status"] = 200;
            $resposta["mensagem"] = "Produto cadastro com sucesso!";
    
        } else {
            $resposta["status"] = 401;
            $resposta["mensagem"] = "Erro ao cadastrar o produto. Tente novamente!";
        }
    
    } else {
        $resposta["status"] = 401;
        $resposta["mensagem"] = "Erro no upload de arquivo. Tente novamente!";
    }

echo json_encode($resposta);

