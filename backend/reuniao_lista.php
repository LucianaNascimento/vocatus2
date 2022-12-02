<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

// conecta o banco de dados
$banco = new PDO('mysql:host=localhost;dbname=vocatus', 'root', '',
    array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

$id = '';
if(isset($_REQUEST["id"])) $id = $_REQUEST["id"];

// prepara uma consulta SELECT
$sql = "SELECT reuniao_id, disciplina_id, date_format(data, '%d/%m/%Y') data, observacao, codigo_verificacao,
latitude, longitude from reuniao WHERE disciplina_id = '$id'";

$comando = $banco->prepare($sql);   

// passa os dados (parametros) para o SELECT
$comando->execute(array());

$resposta["dados"] = $comando->fetchAll();

echo json_encode($resposta);