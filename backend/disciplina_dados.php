<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

// conecta o banco de dados
$banco = new PDO('mysql:host=localhost;dbname=vocatus', 'root', '',
    array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

$id = 0;
if(isset($_REQUEST["id"])) $id = $_REQUEST["id"];

// busca dados da disciplina
$sql = 'SELECT * from disciplina WHERE disciplina_id = ? ';

$comando = $banco->prepare($sql);

// passa os dados (parametros) para o SELECT
$comando->execute(array($id));

$resposta["dados"] = $comando->fetch();

// lista as reunioes existentes
$sql = 'SELECT * from reuniao WHERE disciplina_id = ?';
$comando = $banco->prepare($sql);
$comando->execute(array($id));

$resposta["reunioes"] = array();
while($registro = $comando->fetch()) {
    $reuniao["reuniao_id"] = $registro["reuniao_id"];
    $reuniao["data"] = $registro["data"];
    $reuniao["observacao"] = $registro["observacao"];
    $reuniao["codigo_verificacao"] = $registro["codigo_verificacao"];
    $reuniao["latitude"] = $registro["latitude"];
    $reuniao["longitude"] = $registro["longitude"];

    array_push($resposta["reunioes"], $reuniao);
}

// lista as anexos existentes
$sql = 'SELECT * from anexos WHERE disciplina_id = ?';
$comando = $banco->prepare($sql);
$comando->execute(array($id));

$resposta["anexos"] = array();
while($registro = $comando->fetch()) {    
  $anexo["data"] = $registro["data"];
  $anexo["arquivo"] = $registro["arquivo"];

  array_push($resposta["anexos"], $anexo);
}

echo json_encode($resposta);