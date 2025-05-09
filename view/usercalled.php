<?php
require_once '../controller/userAuthCalled.php';

session_start();

$id = $_SESSION['user']['id'] ?? null;
$name = $_SESSION['user']['name'] ?? null;
$cpf = $_SESSION['user']['cpf'] ?? null;
$email = $_SESSION['user']['email'] ?? null;
$telephone = $_SESSION['user']['telephone'] ?? null;
$password = $_SESSION['user']['password'] ?? null;

$chamadosModel = new userAuthCalled();
$result = null;
$action = null;

// Verifica se o método é POST e se o campo 'tipo' foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tipo'])) {
    $action = $_POST['tipo'];

    switch ($action) {
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
        case 'limpar':
            $action = null;
            $result = null;
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

        <?php if (!$action || $action === 'limpar'): ?>
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
        <?php elseif ($action === 'buscar' && $result): ?>
            <!-- Exibição do chamado buscado -->
            <div class="bg-white p-4 rounded shadow mb-4">
                <h2 class="text-xl font-semibold mb-2">Detalhes do Chamado</h2>
                <pre class="bg-gray-100 p-2 rounded"><?php echo print_r($result, true); ?></pre>
                <form method="POST" class="mt-4">
                    <input type="hidden" name="tipo" value="limpar">
                    <button type="submit" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Limpar</button>
                </form>
            </div>

            <!-- Formulário para cancelar o chamado -->
            <div class="bg-white p-4 rounded shadow">
                <h2 class="text-xl font-semibold mb-2">Cancelar Chamado</h2>
                <form method="POST" class="space-y-2">
                    <input type="hidden" name="tipo" value="cancelar">
                    <input type="hidden" name="idCalled" value="<?php echo htmlspecialchars($result['id'] ?? ''); ?>">
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Cancelar</button>
                </form>
            </div>
        <?php elseif ($action === 'listar' && $result): ?>
            <!-- Exibição da lista de chamados -->
            <div class="bg-white p-4 rounded shadow mb-4">
                <h2 class="text-xl font-semibold mb-2">Lista de Chamados</h2>
                <pre class="bg-gray-100 p-2 rounded"><?php echo print_r($result, true); ?></pre>
                <form method="POST" class="mt-4">
                    <input type="hidden" name="tipo" value="limpar">
                    <button type="submit" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Limpar</button>
                </form>
            </div>
        <?php endif; ?>

        <!-- Exibição de mensagens ou erros -->
        <?php if ($result && !is_array($result)): ?>
            <div class="bg-white p-4 rounded shadow mt-4">
                <p class="text-gray-700"><?php echo htmlspecialchars($result); ?></p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>