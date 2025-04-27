<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Cliente</title>
</head>
<body>
<style>
    body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f9;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    flex-direction: column;
    flex: 1rem;
    
}

form {
    background: #ffffff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 400px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

h1 {
    font-size: 1.5rem;
    color: #333;
    margin-bottom: 20px;
    text-align: center;
}

input[type="text"],
input[type="number"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 1rem;
    margin-inline: auto;
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
}

button:hover {
    background-color: #0056b3;
}

fieldset {
    border: none;
    margin-bottom: 20px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}
</style>
<fieldset>
    <form action="../model/buscaNome.php" method="POST">
        <H1>digite o seu nome completo:</H1>
        <input type="text" name="cxbusca" placeholder="Nome do cliente" required>
        <button type="submit">buscar</button>
    </form>
</fieldset>

    <form action="../model/inserirCliente.php" method="post">
        <h1>Cadastro de Cliente</h1>
        <input type="text" name="cliente" placeholder="Nome do cliente" required>
        <input type="text" name="cpf" placeholder="CPF do cliente" required>
        <input type="number" name="codvendedor" placeholder="Código do vendedor" required>
        <button type="submit">Salvar</button>
    </form>
</body>
</html>