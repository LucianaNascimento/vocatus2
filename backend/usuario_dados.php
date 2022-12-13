<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

// conecta o banco de dados
$banco = new PDO('mysql:host=localhost;dbname=vocatus', 'root', '',
    array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

$id = 0;
if(isset($_REQUEST["id"])) $id = $_REQUEST["id"];

$sql = "SELECT * from usuarios WHERE usuario_id = ?";

// passa os dados (parametros) para o SELECT
$comando = $banco->prepare($sql);

$comando->execute(array($id));

$resposta["dados"] = $comando->fetchAll();

echo json_encode($resposta);