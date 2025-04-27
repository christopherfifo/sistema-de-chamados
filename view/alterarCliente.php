<?php
require_once "../factory/conexao.php";

// Verifica se o ID foi passado pelo GET
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $conn = new Caminho;
    $query = "SELECT * FROM tbcliente WHERE codcli = :id";

    $buscar = $conn->getConn()->prepare($query);
    $buscar->bindParam(':id', $_GET['id'], PDO::PARAM_INT);

    $buscar->execute();

    if ($buscar->rowCount()) {
        $linha = $buscar->fetch(PDO::FETCH_ASSOC);
    } else {
        echo "<script>
            alert('Cliente não encontrado!');
            window.location.href='../view/cadCliente.php';
        </script>";
        exit;
    }
} else {
    echo "<script>
        alert('ID do cliente não informado!');
        window.location.href='../view/cadCliente.php';
    </script>";
    exit;
}
?>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f9;
        margin: 0;
        padding: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
    }

    #cxcliente, #cxbotao {
        background: #ffffff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 400px;
        margin-bottom: 20px;
        text-align: center;
    }

    h1 {
        font-size: 1.5rem;
        color: #333;
        margin-bottom: 20px;
    }

    p {
        font-size: 1rem;
        color: #555;
        margin: 5px 0;
    }

    button {
        width: 100%;
        padding: 10px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 4px;
        font-size: 1rem;
        cursor: pointer;
        margin-top: 10px;
    }

    button:hover {
        background-color: #0056b3;
    }

    form {
        margin: 0;
    }

    input[type="text"], input[type="number"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 1rem;
    }
</style>

<div id="cxcliente">
    <h1>Alterar Cliente</h1>
    <form action="../model/alterarCli.php?id=<?php echo $linha['codcli']; ?>" method="POST">
        <input type="hidden" name="codcli" value="<?php echo $linha['codcli']; ?>">
        <input type="text" name="cliente" value="<?php echo $linha['cliente']; ?>" placeholder="Nome do cliente" required>
        <input type="text" name="cpf" value="<?php echo $linha['cpf']; ?>" placeholder="CPF do cliente" required>
        <input type="number" name="codvendedor" value="<?php echo $linha['codvendedor']; ?>" placeholder="Código do vendedor" required>
        <button type="submit">Salvar Alterações</button>
    </form>
</div>