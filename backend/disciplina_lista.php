<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

// conecta o banco de dados
$banco = new PDO('mysql:host=localhost;dbname=vocatus', 'root', '',
    array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

// prepara uma consulta SELECT
$comando = $banco->prepare('SELECT * from disciplina ORDER BY nome');

$resposta["dados"] = $consulta->fetchAll();

// passa os dados (parametros) para o SELECT
// $comando->execute(array($_REQUEST["disciplna"]));

// $resposta["status"] = 200;
// $resposta["itens"] = array();
// while($registro = $comando->fetch()) {
//     $item["id"] = $registro["cardapio_id"];
//     $item["nome"] = $registro["cardapio_nome"];
//     $item["foto"] = $registro["cardapio_foto"];
//     $item["descricao"] = $registro["cardapio_descricao"];
//     $item["preco"] = $registro["cardapio_preco"];
//     $item["disponivel"] = $registro["cardapio_disponivel"];

//     array_push($resposta["itens"], $item);
// }

echo json_encode($resposta);