<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

// conecta o banco de dados
$banco = new PDO('mysql:host=localhost;dbname=vocatus', 'root', '',
    array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

$id = '';
if(isset($_REQUEST["id"])) $id = $_REQUEST["id"];

$sql = "SELECT reuniao_id, reuniao.disciplina_id, date_format(data, '%d/%m/%Y') data, reuniao.observacao, codigo_verificacao,
latitude, longitude, disciplina.nome from reuniao
INNER JOIN disciplina ON reuniao.disciplina_id = disciplina.disciplina_id
WHERE reuniao.disciplina_id = '$id'";

$comando = $banco->prepare($sql);   

// passa os dados (parametros) para o SELECT
$comando->execute(array());

$resposta["dados"] = $comando->fetchAll();

echo json_encode($resposta);