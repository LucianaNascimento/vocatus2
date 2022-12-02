<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

// conecta o banco de dados
$banco = new PDO('mysql:host=localhost;dbname=vocatus', 'root', '',
    array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

$tipo = "a";
if(isset($_REQUEST["tipo"])) $tipo = $_REQUEST["tipo"];

$professor = 0;
if(isset($_REQUEST["professor"])) $professor = $_REQUEST["professor"];

// prepara uma consulta SELECT
$sql = 'SELECT * from disciplina WHERE date(data_conclusao) ';
if($tipo == "i") {
    $sql .= "<";
}else{
    $sql .= ">=";
}

$sql .= 'CURDATE() 
and professor_id = '.$professor.'
ORDER BY nome';

$comando = $banco->prepare($sql);

// passa os dados (parametros) para o SELECT
$comando->execute(array());

$resposta["dados"] = $comando->fetchAll();

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