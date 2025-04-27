<?php
require_once "../factory/conexao.php";

if (!empty($_POST['cliente']) && !empty($_POST['cpf']) && !empty($_POST['codvendedor'])) {
    $conn = new Caminho;
    $query = "INSERT INTO tbcliente (cliente, cpf, codvendedor) VALUES (:cliente, :cpf, :codvendedor)";

    $cadastrar = $conn->getConn()->prepare($query);

    $cadastrar->bindParam(':cliente', $_POST['cliente'], PDO::PARAM_STR);
    $cadastrar->bindParam(':cpf', $_POST['cpf'], PDO::PARAM_STR);
    $cadastrar->bindParam(':codvendedor', $_POST['codvendedor'], PDO::PARAM_INT);

    $cadastrar->execute();

    if ($cadastrar->rowCount()) {
        echo "<script>
        alert('Cliente cadastrado com sucesso!');
        window.location.href='../view/cadCliente.php';
        </script>";
    } else {
        echo "Erro ao cadastrar cliente.";
    }
} else {
    echo "Dados incompletos.";
}
?>