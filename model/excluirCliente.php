<?php
require_once "../factory/conexao.php";

if (isset($_GET['id']) && $_GET['id'] != "") {
    $conn = new Caminho;
    $query = "DELETE FROM tbcliente WHERE codcli = :id";

    $excluir = $conn->getConn()->prepare($query);
    $excluir->bindParam(':id', $_GET['id'], PDO::PARAM_STR);

    if ($excluir->execute()) {
        echo "<script>
        alert('Cliente excluído com sucesso!');
        window.location.href='../view/cadCliente.php';
        </script>";
    } else {
        echo "<script>
        alert('Erro ao excluir cliente!');
        window.location.href='../view/cadCliente.php';
        </script>";
    }
} else {
    echo "<script>
    alert('ID do cliente não informado!');
    window.location.href='../view/cadCliente.php';
    </script>";
}
?>