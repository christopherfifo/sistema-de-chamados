<?php
require_once "../factory/conexao.php";

// Verifica se os dados foram enviados pelo POST
if (isset($_POST['codcli']) && !empty($_POST['cliente']) && !empty($_POST['cpf']) && !empty($_POST['codvendedor'])) {
    $codcli = $_POST['codcli'];
    $cliente = $_POST['cliente'];
    $cpf = $_POST['cpf'];
    $codvendedor = $_POST['codvendedor'];

    try {
        $conn = new Caminho;
        $query = "UPDATE tbcliente 
                  SET cliente = :cliente, cpf = :cpf, codvendedor = :codvendedor 
                  WHERE codcli = :codcli";

        $atualizar = $conn->getConn()->prepare($query);

  
        $atualizar->bindParam(':cliente', $cliente, PDO::PARAM_STR);
        $atualizar->bindParam(':cpf', $cpf, PDO::PARAM_STR);
        $atualizar->bindParam(':codvendedor', $codvendedor, PDO::PARAM_INT);
        $atualizar->bindParam(':codcli', $codcli, PDO::PARAM_INT);

        // Executa a query
        $atualizar->execute();

        if ($atualizar->rowCount()) {
            echo "<script>
                alert('Cliente atualizado com sucesso!');
                window.location.href='../view/cadCliente.php';
            </script>";
        } else {
            echo "<script>
                alert('Nenhuma alteração foi feita.');
                window.location.href='../view/cadCliente.php';
            </script>";
        }
    } catch (PDOException $e) {
        echo "Erro ao atualizar cliente: " . $e->getMessage();
    }
} else {
    echo "<script>
        alert('Dados incompletos para atualização!');
        window.location.href='../view/cadCliente.php';
    </script>";
}
?>