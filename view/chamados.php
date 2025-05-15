<?php require_once '../model/tectechniciansCallled.php'; ?>
<?php require_once '../model/userCalled.php'; ?>
<?php require_once '../controller/authCalled.php'; ?>

<!DOCTYPE html>
<html lang="pt-br" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: '#4bb6b7',
                        darkblue: 'rgb(43, 43, 151)',
                    }
                }
            }
        }
    </script>
    <script>
        (function() {
            const userPref = localStorage.getItem('theme');
            const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

            if (userPref === 'dark' || (!userPref && systemPrefersDark)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();

        const toggleTheme = () => {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            } else {
                document.documentElement.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            }
        }
    </script>
    <title>Sistema de Chamados</title>
</head>

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


// Pega o ID do chamado atual
$currentIdParam = isset($_GET['id']) ? '?id=' . $_GET['id'] : '';

// Deletar chamado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deleteCalledId'])) {
    $id = $_POST['deleteCalledId'];
    $techniciansCalled = new CalledTechnicians();
    if ($techniciansCalled->deleteCalled($id)) {
        $_SESSION['toast'] = ['type' => 'success', 'message' => 'Chamado deletado com sucesso!'];
        // Se deletou o mesmo que estava aberto, remove ?id
        $redirect = ($_GET['id'] ?? null) == $id ? '' : $currentIdParam;
        header("Location: chamados.php$redirect");
        exit;
    } else {
        $_SESSION['toast'] = ['type' => 'error', 'message' => 'Erro ao deletar o chamado.'];
        header("Location: chamados.php$currentIdParam");
        exit;
    }
}

// Aceitar chamado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acceptCalled'])) {
    $idCalled = $_POST['acceptCalledId'] ?? null;
    $user = $_SESSION['user'] ?? null;
    $idTechnician = $user['id'] ?? null;
    $matriculaTechnician = $user['matricula'] ?? null;

    if ($idCalled && $idTechnician && $matriculaTechnician) {
        $techniciansCalled = new CalledTechnicians();
        if ($techniciansCalled->acceptCalled($idCalled, $idTechnician, $matriculaTechnician)) {
            $_SESSION['toast'] = ['type' => 'success', 'message' => 'Chamado aceito com sucesso!'];
        } else {
            $_SESSION['toast'] = ['type' => 'error', 'message' => 'Erro ao aceitar o chamado.'];
        }
    } else {
        $_SESSION['toast'] = ['type' => 'error', 'message' => 'Erro: dados do técnico não encontrados.'];
    }
    header("Location: chamados.php$currentIdParam");
    exit;
}

// Criar chamado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['createCalled'])) {
    $idUser = $_POST['idUser'];
    $codeCalled = $_POST['codeCalled'];
    $description = $_POST['description'];

    $techniciansCalled = new CalledTechnicians();
    if ($techniciansCalled->createCalled($idUser, $codeCalled, $description)) {
        $_SESSION['toast'] = ['type' => 'success', 'message' => 'Chamado criado com sucesso!'];
    } else {
        $_SESSION['toast'] = ['type' => 'error', 'message' => 'Erro ao criar o chamado.'];
    }
    header("Location: chamados.php$currentIdParam");
    exit;
}

// Atualizar detalhes
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updateDetail'])) {
    $idCalled = $_POST['idCalled'];
    $description = $_POST['description'];
    $idTechnician = $_POST['idTechnician'];
    $matriculaTechnician = $_POST['matriculaTechnician'];

    $techniciansCalled = new CalledTechnicians();
    if ($techniciansCalled->UpdateDetailTec($idCalled, $idTechnician, $matriculaTechnician, $description)) {
        $_SESSION['toast'] = ['type' => 'success', 'message' => 'Detalhe atualizado com sucesso!'];
    } else {
        $_SESSION['toast'] = ['type' => 'error', 'message' => 'Erro ao atualizar o detalhe do chamado.'];
    }
    header("Location: chamados.php$currentIdParam");
    exit;
}

// Atualizar status
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updateStatus'])) {
    $idCalled = $_POST['idCalled'];
    $newStatus = $_POST['status'];

    $techniciansCalled = new CalledTechnicians();
    if ($techniciansCalled->Status($idCalled, $newStatus)) {
        $_SESSION['toast'] = ['type' => 'success', 'message' => 'Status atualizado com sucesso!'];
    } else {
        $_SESSION['toast'] = ['type' => 'error', 'message' => 'Erro ao atualizar o status do chamado.'];
    }
    header("Location: chamados.php$currentIdParam");
    exit;
}

?>

<body class="bg-gray-100 text-gray-900 dark:bg-gray-900 dark:text-white">
    <header class="bg-primary text-white py-4 shadow flex flex-row items-center">
        <nav class="flex mx-5">
            <a href="./home.php" class="text-white hover:underline">Home</a>
        </nav>

        <h1 class="text-3xl text-center font-bold flex-1">Sistema de Chamados</h1>

        <button onclick="toggleTheme()" class="text-sm underline hover:text-gray-200 transition flex items-center mx-5">
            <i class="fa-solid fa-moon mr-2"></i>
            Alternar tema
        </button>
    </header>
    <main class="p-6 flex flex-col gap-10">
        <section class="flex flex-col lg:flex-row gap-6">
            <section class="lg:w-3/5">
                <h2 class="text-xl font-semibold mb-4">Listagem de Chamados</h2>
                <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded shadow">
                    <table class="min-w-full text-sm text-center">
                        <thead class="bg-gray-200 dark:bg-darkblue text-gray-800 dark:text-white">
                            <tr>
                                <th class="p-3">ID</th>
                                <th class="p-3">Código</th>
                                <th class="p-3">Descrição</th>
                                <th class="p-3">Status</th>
                                <th class="p-3">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $techniciansCalled = new CalledTechnicians();
                            $calleds = $techniciansCalled->listAllCalleds();
                            if ($calleds) {
                                foreach ($calleds as $called) {
                                    echo "<tr class='border-b border-gray-300 dark:border-gray-700'>";
                                    echo "<td class='p-3'>" . htmlspecialchars($called['id']) . "</td>";
                                    echo "<td class='p-3'>" . htmlspecialchars($called['code_called']) . "</td>";
                                    echo "<td class='p-3'>" . htmlspecialchars($called['description']) . "</td>";
                                    echo "<td class='p-3'>" . htmlspecialchars($called['estatus']) . "</td>";
                                    echo "<td class='p-3'>";
                                    echo "<a href='?id=" . htmlspecialchars($called['id']) . "' class='text-primary hover:underline'>Ver</a> | ";
                                    echo "<form method='POST' action='' class='inline'>
                                            <input type='hidden' name='deleteCalledId' value='" . htmlspecialchars($called['id']) . "'>
                                            <button type='submit' class='text-red-500 hover:underline ml-1' onclick=\"return confirm('Tem certeza que deseja deletar este chamado?')\">Deletar</button>
                                        </form>";
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='5' class='p-3'>Nenhum chamado encontrado.</td></tr>";
                            }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5" class="text-right p-4 font-semibold">
                                    Total de Chamados: <?php echo isset($calleds) && is_array($calleds) ? count($calleds) : 0; ?>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </section>

            <section class="lg:w-2/5">
                <h2 class="text-xl font-semibold mb-4">Detalhes do Chamado</h2>
                <div class="bg-white dark:bg-gray-800 p-4 rounded shadow">
                    <?php
                    if (isset($_GET['id'])) {
                        $idCalled = $_GET['id'];
                        $userCalled = new userCalled();
                        $details = $userCalled->getDetailsUSer($idCalled);
                        if ($details) {
                            echo "<p><strong>ID:</strong> {$details['called_id']}</p>";
                            echo "<p><strong>Código:</strong> {$details['code_called']}</p>";
                            echo "<p><strong>Descrição:</strong> {$details['called_description']}</p>";
                            echo "<p><strong>Status:</strong> {$details['called_status']}</p><br>";
                            echo "<p><strong>Técnico:</strong> {$details['matricula_technician']}</p>";
                            echo "<p><strong>Detalhe:</strong> {$details['detail_description']}</p>";
                            echo "<p><strong>Cliente:</strong> {$details['client_name']}</p><br>";
                            $disabled = !empty($details['matricula_technician']);
                            $disabledAttr = $disabled ? 'disabled' : '';
                            $btnClass = $disabled
                                ? 'bg-gray-400 text-white cursor-not-allowed opacity-60'
                                : 'bg-green-500 text-white hover:bg-green-600';
                            echo "<form method='POST' class='mt-4'>
        <input type='hidden' name='acceptCalledId' value='" . htmlspecialchars($details['called_id']) . "'>
        <button type='submit' name='acceptCalled' class='px-4 py-2 rounded " . $btnClass . "' " . $disabledAttr . ">
            " . ($disabled ? 'Aceito' : 'Aceitar Chamado') . "
        </button>
    </form>";
                        } else {
                            echo "<p>Nenhum detalhe encontrado.</p>";
                        }
                    }
                    ?>
                </div>
            </section>
        </section>

        <?php if (isset($_GET['id'])) { ?>
            <section class="flex flex-col lg:flex-row gap-6">
                <section class="lg:w-2/5">
                    <h2 class="text-xl font-semibold mb-4">Atualizar Status</h2>
                    <form method="POST" class="bg-white dark:bg-gray-800 p-4 rounded shadow">
                        <input type="hidden" name="idCalled" value="<?php echo htmlspecialchars($_GET['id']); ?>">
                        <label class="block mb-2">Novo Status:</label>
                        <select name="status" class="border border-gray-300 dark:border-gray-600 p-2 rounded w-full mb-4 bg-white dark:bg-gray-700 text-black dark:text-white" required>
                            <option value="Aberto">Aberto</option>
                            <option value="Em Andamento">Em Andamento</option>
                            <option value="Fechado">Fechado</option>
                        </select>
                        <button type="submit" name="updateStatus" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Atualizar</button>
                    </form>
                </section>

                <section class="lg:w-3/5">
                    <h2 class="text-xl font-semibold mb-4">Editar Detalhes</h2>
                    <form method="POST" class="bg-white dark:bg-gray-800 p-4 rounded shadow">
                        <input type="hidden" name="idCalled" value="<?php echo htmlspecialchars($_GET['id']); ?>">
                        <label class="block mb-2">Descrição do Detalhe:</label>
                        <textarea name="description" rows="4" class="border border-gray-300 dark:border-gray-600 p-2 rounded w-full mb-4 bg-white dark:bg-gray-700 text-black dark:text-white" required><?php echo htmlspecialchars($details['detail_description'] ?? ''); ?></textarea>
                        <input type="hidden" name="idTechnician" value="<?php echo htmlspecialchars($details['id_technician'] ?? ''); ?>">
                        <input type="hidden" name="matriculaTechnician" value="<?php echo htmlspecialchars($details['matricula_technician'] ?? ''); ?>">
                        <button type="submit" name="updateDetail" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Atualizar</button>
                    </form>
                </section>
            </section>
        <?php } ?>

        <section>
            <h2 class="text-xl font-semibold mb-4">Criar Novo Chamado</h2>
            <form method="POST" class="bg-white dark:bg-gray-800 p-6 rounded shadow">
                <label class="block mb-2">ID do Usuário:</label>
                <input type="number" name="idUser" required class="border border-gray-300 dark:border-gray-600 p-2 rounded w-full mb-4 bg-white dark:bg-gray-700 text-black dark:text-white">

                <label class="block mb-2">Código do Chamado:</label>
                <input type="text" name="codeCalled" required class="border border-gray-300 dark:border-gray-600 p-2 rounded w-full mb-4 bg-white dark:bg-gray-700 text-black dark:text-white">

                <label class="block mb-2">Descrição:</label>
                <textarea name="description" rows="4" required class="border border-gray-300 dark:border-gray-600 p-2 rounded w-full mb-4 bg-white dark:bg-gray-700 text-black dark:text-white"></textarea>

                <button type="submit" name="createCalled" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Criar Chamado</button>
            </form>
        </section>
    </main>

    <?php if (!empty($_SESSION['toast'])):
        $toast = $_SESSION['toast'];
        $bgColor = $toast['type'] === 'success' ? 'bg-green-500' : 'bg-red-500';
        $message = htmlspecialchars($toast['message'], ENT_QUOTES, 'UTF-8');
        unset($_SESSION['toast']);
    ?>
        <div id="toast"
            class="fixed bottom-5 right-5 z-50 text-white px-5 py-3 rounded-lg shadow-lg transition-opacity duration-300 <?= $bgColor ?>">
            <?= $message ?>
        </div>

        <script>
            // Oculta o toast após 3 segundos
            setTimeout(() => {
                const toast = document.getElementById('toast');
                if (toast) {
                    toast.style.opacity = '0';
                    setTimeout(() => toast.remove(), 300); // Remove após fade-out
                }
            }, 3000);
        </script>
    <?php endif; ?>
</body>

</html>