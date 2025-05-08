<?php
<!-- filepath: c:\xampp\htdocs\sistema de chamados\view\usercalled.php -->
<?php
require_once '../controller/userAuthCalled.php';

session_start();

$id = $_SESSION['user']['id'] ?? null;
$name = $_SESSION['user']['name'] ?? null;
$cpf = $_SESSION['user']['cpf'] ?? null;
$email = $_SESSION['user']['email'] ?? null;
$telephone = $_SESSION['user']['telephone'] ?? null;
$password = $_SESSION['user']['password'] ?? null;
$tipo = $_SESSION['user']['tipo'] ?? null;
$estatus = $_SESSION['user']['estatus'] ?? "active";

$chamadosModel = new userAuthCalled();
$result = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tipo = $_POST['tipo'] ?? '';

    switch ($tipo) {
        case 'criar':
            $description = $_POST['description'] ?? '';
            $result = $chamadosModel->Called($id, $description);
            break;
        case 'buscar':
            $idCalled = $_POST['idCalled'] ?? '';
            $result = $chamadosModel->getCalled($idCalled);
            break;
        case 'listar':
            $result = $chamadosModel->listCalleds($id);
            break;
        case 'cancelar':
            $idCalled = $_POST['idCalled'] ?? '';
            $result = $chamadosModel->cancelCalled($idCalled, "CANCELADO");
            break;
        default:
            $result = "Ação inválida!";
            break;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Chamados</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Sistema de Chamados</h1>

        <!-- Formulário para criar um chamado -->
        <div class="bg-white p-4 rounded shadow mb-4">
            <h2 class="text-xl font-semibold mb-2">Criar Chamado</h2>
            <form method="POST" class="space-y-2">
                <input type="hidden" name="tipo" value="criar">
                <label for="description" class="block font-medium">Descrição:</label>
                <textarea name="description" id="description" class="w-full border rounded p-2" required></textarea>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Criar</button>
            </form>
        </div>

        <!-- Formulário para buscar um chamado -->
        <div class="bg-white p-4 rounded shadow mb-4">
            <h2 class="text-xl font-semibold mb-2">Buscar Chamado</h2>
            <form method="POST" class="space-y-2">
                <input type="hidden" name="tipo" value="buscar">
                <label for="idCalled" class="block font-medium">ID do Chamado:</label>
                <input type="text" name="idCalled" id="idCalled" class="w-full border rounded p-2" required>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Buscar</button>
            </form>
        </div>

        <!-- Formulário para listar todos os chamados -->
        <div class="bg-white p-4 rounded shadow mb-4">
            <h2 class="text-xl font-semibold mb-2">Listar Chamados</h2>
            <form method="POST">
                <input type="hidden" name="tipo" value="listar">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Listar</button>
            </form>
        </div>

        <!-- Formulário para cancelar um chamado -->
        <div class="bg-white p-4 rounded shadow mb-4">
            <h2 class="text-xl font-semibold mb-2">Cancelar Chamado</h2>
            <form method="POST" class="space-y-2">
                <input type="hidden" name="tipo" value="cancelar">
                <label for="idCalledCancel" class="block font-medium">ID do Chamado:</label>
                <input type="text" name="idCalled" id="idCalledCancel" class="w-full border rounded p-2" required>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Cancelar</button>
            </form>
        </div>

        <!-- Exibição dos resultados -->
        <div class="bg-white p-4 rounded shadow">
            <h2 class="text-xl font-semibold mb-2">Resultados</h2>
            <div class="overflow-auto">
                <?php
                if ($result) {
                    if (is_array($result)) {
                        echo "<pre class='bg-gray-100 p-2 rounded'>" . print_r($result, true) . "</pre>";
                    } else {
                        echo "<p class='text-gray-700'>$result</p>";
                    }
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>