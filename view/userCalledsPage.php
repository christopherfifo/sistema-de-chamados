<?php
require_once '../controller/userAuthCalled.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$id_user = $_SESSION['user']['id'] ;
$name = $_SESSION['user']['name'] ;
$cpf = $_SESSION['user']['cpf'] ;
$email = $_SESSION['user']['email'] ;
$telephone = $_SESSION['user']['telephone'] ;
$password = $_SESSION['user']['password'] ;

if (isset($_GET['action']) && !empty($_GET['action'])) {
    $action = $_GET['action'];
    $id_chamado = isset($_GET['id_chamado']) ? $_GET['id_chamado'] : '';

switch ($action) {
        case 'busca':
            $userCalled = new userAuthCalled();
            $called = $userCalled->getCalled($id_chamado);
            if ($called) {
                $descricao = $called['description'];
            } else {
                echo "Erro ao obter chamado!";
            }
            break;
        case 'listar_chamados':
            $userCalled = new userAuthCalled();
            $calleds = $userCalled->listCalleds($id_user);
            break;
        default:
            break;
    }
    
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'criar' && isset($_POST['descricao']) && !empty($_POST['descricao'])) {
        $descricao = $_POST['descricao'];
        $userCalled = new userAuthCalled();
        $result = $userCalled->Called($id_user, $descricao);
        if ($result) {
            echo "Chamado criado com sucesso!";
        } else {
            echo "Erro ao criar chamado!";
        }
    } elseif (isset($_POST['action']) && $_POST['action'] === 'deletar' && isset($_POST['id']) && !empty($_POST['id'])) {

        $id_chamado = $_POST['id'];
        $status = "CANCELADO";
        $userCalled = new userAuthCalled();
        $result = $userCalled->cancelCalled($id_chamado, $status);
        if ($result) {
            echo "Chamado deletado com sucesso!";
        } else {
            echo "Erro ao deletar chamado!";
        }
    }
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
  <script src="https://cdn.tailwindcss.com"></script>
  <title>Gestão de Chamados</title>
  <script>
    tailwind.config = {
      darkMode: 'class',
      theme: {
        extend: {
          colors: {
            primary: '#4bb6b7',
            darkblue: 'rgb(43, 43, 151)',
          },
        }
      }
    }
  </script>
</head>

<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-white min-h-screen p-6 relative">

  <!-- Botão para abrir modal (Bloco 3) -->
  <button onclick="document.getElementById('modal').classList.remove('hidden')" 
          class="absolute top-6 right-6 bg-primary text-white px-4 py-2 rounded-xl hover:bg-[#3ba7a7] transition duration-300">
    <i class="fas fa-plus"></i> Novo Chamado
  </button>

  <!-- Bloco 1: Área de busca e resultado único -->
 <div class="max-w-4xl mx-auto bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-6 space-y-6 mt-12">
  <form method="GET" action="userCalledsPage.php" class="flex flex-col sm:flex-row gap-4 items-center">
    <input type="text" name="id_chamado" placeholder="Digite o ID" 
           class="flex-grow p-3 rounded-xl border dark:border-gray-600 bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white" />
    <input type="hidden" name="action" value="busca" />
    <button type="submit" class="bg-primary text-white px-6 py-3 rounded-xl hover:bg-[#3ba7a7] transition">
      Buscar
    </button>
  </form>


    <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-xl space-y-2">
      <h4 class="text-lg font-semibold">Resultado:</h4>
      <?php if (!empty($descricao)): ?>
      <div class="flex justify-between items-center bg-white dark:bg-gray-800 p-3 rounded-xl">
        <div>
          <p><strong>ID:</strong> <?php echo htmlspecialchars($id_chamado); ?></p>
          <p><strong>Descrição:</strong> <?php echo htmlspecialchars($descricao); ?></p>
        </div>
        <form method="POST">
          <input type="hidden" name="id_chamado" value="<?php echo htmlspecialchars($id_chamado); ?>">
          <input type="hidden" name="action" value="deletar" />
          <button type="submit" class="text-red-600 hover:text-red-800 transition font-bold">
            <i class="fas fa-trash"></i> Deletar
          </button>
        </form>
        <?php endif; ?>
      </div>
    </div>


  <!-- Bloco 2: Lista de chamados -->
  <div class="max-w-4xl mx-auto mt-6 bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-6 space-y-4">
    <form method="GET">
      <input type="hidden" name="action" value="listar_chamados">
    </form>

    <h4 class="text-lg font-semibold mb-2">Lista de Chamados:</h4>

    <?php if (!empty($calleds) && is_array($calleds)): ?>
        <?php foreach ($calleds as $called): ?>
            <div class="flex justify-between items-center bg-gray-100 dark:bg-gray-700 p-3 rounded-xl">
                <div>
                    <p><strong>ID:</strong> <?php echo htmlspecialchars($called['id']); ?></p>
                    <p><strong>Descrição:</strong> <?php echo htmlspecialchars($called['description']); ?></p>
                </div>
                <form method="POST">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($called['id']); ?>">
                    <input type="hidden" name="action" value="deletar" />
                    <button type="submit" class="text-red-600 hover:text-red-800 transition font-bold">
                        <i class="fas fa-trash"></i> Deletar
                    </button>
                </form>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p class="text-center text-gray-500 dark:text-gray-400">Nenhum chamado encontrado.</p>
    <?php endif; ?>


  <!-- Bloco 3: Modal para novo chamado -->
  <div id="modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-xl w-full max-w-md relative">
      <h2 class="text-xl font-bold mb-4">Novo Chamado</h2>
      <form method="POST">
        <input type="hidden" name="action" value="criar" />
        <textarea name="descricao" placeholder="Descreva o problema..." rows="4"
          class="w-full p-3 rounded-xl border dark:border-gray-600 bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white resize-none mb-4"></textarea>
        <div class="flex justify-end space-x-4">
          <button type="button" onclick="document.getElementById('modal').classList.add('hidden')"
                  class="px-4 py-2 rounded-xl border border-gray-500 text-gray-700 dark:text-white hover:bg-gray-200 dark:hover:bg-gray-700 transition">
            Cancelar
          </button>
          <button type="submit" class="bg-primary text-white px-4 py-2 rounded-xl hover:bg-[#3ba7a7] transition">
            Enviar
          </button>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
