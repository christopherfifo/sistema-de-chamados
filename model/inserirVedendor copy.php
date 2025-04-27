<?php
require_once "../factory/conexao.php";

if(method_exist$_SERVER['REQUEST_METHOD'] === 'POST' &&  $_POST['cxvendedor'] != "") {
$conn = new Caminho();
$query = $conn->getConexao()->prepare("INSERT INTO vendedor (cod_vendedor) VALUES (:cod_vendedor)");
$query->bindValue(':cod_vendedor', $_POST['cxvendedor']);
$query->execute();
}

?>