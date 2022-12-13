<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

// conecta o banco de dados
$banco = new PDO('mysql:host=localhost;dbname=vocatus', 'root', '',
    array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

$id = '';
if(isset($_REQUEST["id"])) $id = $_REQUEST["id"];

// prepara uma consulta SELECT
$sql = "SELECT reuniao.*, presencas.*, usuarios.*,
if(round(reuniao.latitude,4) = round(presencas.latitude,4)
 AND round(reuniao.longitude,4) = round(presencas.longitude,4), 
'ok', 'fora da área') situacao
 FROM 
reuniao INNER JOIN presencas USING (reuniao_id)
INNER JOIN usuarios ON (aluno_id = usuario_id)
WHERE reuniao_id = ?
ORDER BY nome";

$comando = $banco->prepare($sql);   

// passa os dados (parametros) para o SELECT
$comando->execute(array($id));

$resposta["dados"] = $comando->fetchAll();

echo json_encode($resposta);