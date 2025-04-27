<?php
    require_once "../factory/conexao.php";
    if($_POST['cxbusca'] != ""){
       $conn = new Caminho;
       $query = "SELECT * from tbcliente
       where cliente = :id"; 

       $buscar=$conn->getConn()->
       prepare($query);
       
       $buscar->
       bindParam(':id',$_POST['cxbusca'],
       PDO::PARAM_STR);

       $buscar->execute();
       
       if($buscar->rowcount()){
        echo "<script>
        alert('Cliente encontrado!');
        </script>";
       }else{
          echo "<script>
            alert('Cliente não encontrado!');
            window.location.href='../view/cadCliente.php';
          </script>";
       }
    }else{
        echo "Dados incompleto";
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
</style>

<div id="cxcliente">
    <?php
    $linha = $buscar->fetch(PDO::FETCH_ASSOC);
    echo "<h1>Cliente encontrado:</h1>";
    echo "<p>Código: " . $linha['codcli'] . "</p>";
    echo "<p>Cliente: " . $linha['cliente'] . "</p>";
    echo "<p>CPF: " . $linha['cpf'] . "</p>";
    echo "<p>Código do Vendedor: " . $linha['codvendedor'] . "</p>";
    ?>
</div>

<div id="cxbotao">
    <form action="../model/excluirCliente.php?id=<?php echo $linha['codcli']; ?>" method="post">
        <button type="submit">Excluir</button>
    </form>
    <form action="../view/alterarCliente.php?id=<?php echo $linha['codcli']; ?>" method="post">
        <button type="submit">Alterar</button>  
    </form>
</div>