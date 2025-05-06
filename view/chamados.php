<?php require_once '../model/tectechniciansCallled.php'; ?>
<?php require_once '../model/userCalled.php'; ?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>Sistema de Chamados</title>
</head>

<body>
    <header>
        <h1 class="text-3xl flex justify-center my-5 font-semibold">Sistema de Chamados</h1>
    </header>
    <section class="w-full">
        <section id="chamados" class="w-full flex flex-row">
            <section id="listagem" class="w-3/5 flex flex-col items-center mt-10">
                <h2 class="text-2xl flex justify-center">Listagem de Chamados</h2>
                <table class="w-full px-5 mt-5 justify-center [&>td]:text-center">
                    <thead class="bg-gray-200">
                        <tr>
                            <th>ID</th>
                            <th>Código do Chamado</th>
                            <th>Descrição</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $techniciansCalled = new TechniciansCalled();
                        $calleds = $techniciansCalled->listAllCalleds();

                        if ($calleds) {
                            foreach ($calleds as $called) {
                                echo "<tr>";
                                echo "<td class='text-center'>" . htmlspecialchars($called['id']) . "</td>";
                                echo "<td class='text-center'>" . htmlspecialchars($called['code_called']) . "</td>";
                                echo "<td class='text-center'>" . htmlspecialchars($called['description']) . "</td>";
                                echo "<td class='text-center'>" . htmlspecialchars($called['estatus']) . "</td>";
                                echo "<td class='text-center underline'><a href='?id=" . htmlspecialchars($called['id']) . "' class='text-blue-500'>Ver Detalhes</a></td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>Nenhum chamado encontrado.</td></tr>";
                        }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5" class="text-end font-semibold pt-5">Total de Chamados: <?php echo count($calleds); ?></td>
                        </tr>
                    </tfoot>
                </table>
            </section>
            <section id="detalhes" class="w-2/5 flex flex-col items-center mt-10">
                <h2 class="text-2xl flex justify-center">Detalhes do Chamado</h2>
                <?php
                if (isset($_GET['id'])) {
                    $idCalled = $_GET['id'];
                    $userCalled = new userCalled();
                    $details = $userCalled->getDetailsUSer($idCalled);

                    if ($details) {
                        echo "<div class='w-3/4 mx-auto mt-5'>";
                        echo "<p><strong>ID do Chamado:</strong> " . htmlspecialchars($details['called_id']) . "</p>";
                        echo "<p><strong>Código do Chamado:</strong> " . htmlspecialchars($details['code_called']) . "</p>";
                        echo "<p><strong>Descrição do Chamado:</strong> " . htmlspecialchars($details['called_description']) . "</p>";
                        echo "<p><strong>Status do Chamado:</strong> " . htmlspecialchars($details['called_status']) . "</p>";
                        echo "<br>";
                        echo "<p><strong>Técnico Responsável:</strong> " . htmlspecialchars($details['matricula_technician']) . "</p>";
                        echo "<p><strong>Descrição do Detalhe:</strong> " . htmlspecialchars($details['detail_description']) . "</p>";
                        echo "<p><strong>Nome do Cliente:</strong> " . htmlspecialchars($details['client_name']) . "</p>";
                        echo "</div>";
                    } else {
                        echo "<p>Nenhum detalhe encontrado para o chamado com ID: " . htmlspecialchars($idCalled) . "</p>";
                    }
                }
                ?>
            </section>
        </section>
        <?php
        if (isset($_GET['id'])) { ?>
            <section id="atualizar" class="w-full flex flex-row">
                <section id="atualizar_status" class="w-2/5 flex flex-col items-center mt-10">
                    <h2 class="text-2xl flex justify-center">Atualizar Status do Chamado</h2>
                    <form action="" method="POST" class="w-3/4 mx-auto mt-5">
                        <input type="hidden" name="idCalled" value="<?php echo isset($_GET['id']) ? htmlspecialchars($_GET['id']) : ''; ?>">
                        <label for="status" class="block mb-2">Novo Status:</label>
                        <select name="status" id="status" class="border border-gray-300 rounded p-2 mb-4 w-full">
                            <option value="Aberto">Aberto</option>
                            <option value="Em Andamento">Em Andamento</option>
                            <option value="Fechado">Fechado</option>
                        </select>
                        <button type="submit" name="updateStatus" class="bg-blue-500 text-white px-4 py-2 rounded">Atualizar Status</button>
                    </form>
                    <?php
                    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updateStatus'])) {
                        $idCalled = $_POST['idCalled'];
                        $newStatus = $_POST['status'];

                        $techniciansCalled = new TechniciansCalled();
                        if ($techniciansCalled->updateStatus($idCalled, $newStatus)) {
                            echo "<p class='text-green-500 mt-5'>Status atualizado com sucesso!</p>";
                        } else {
                            echo "<p class='text-red-500 mt-5'>Erro ao atualizar o status do chamado.</p>";
                        }
                    }
                    ?>
                </section>
                <section id="editar_detalhes" class="w-3/5 flex flex-col items-center mt-10">
                    <h2 class="text-2xl flex justify-center">Editar Detalhes do chamado</h2>

                    <form action="" method="POST" class="w-3/4 mx-auto mt-5">
                        <input type="hidden" name="idCalled" value="<?php echo isset($_GET['id']) ? htmlspecialchars($_GET['id']) : ''; ?>">
                        <label for="description" class="block mb-2">Descrição do Detalhe:</label>
                        <textarea name="description" id="description" rows="4" class="border border-gray-300 rounded p-2 mb-4 w-full"></textarea>
                        <input type="hidden" name="idTechnician" value="<?php echo isset($details['id_technician']) ? htmlspecialchars($details['id_technician']) : ''; ?>">
                        <input type="hidden" name="matriculaTechnician" value="<?php echo isset($details['matricula_technician']) ? htmlspecialchars($details['matricula_technician']) : ''; ?>">
                        <button type="submit" name="updateDetail" class="bg-blue-500 text-white px-4 py-2 rounded">Atualizar Detalhe</button>
                    </form>
                    <?php
                    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updateDetail'])) {
                        $idCalled = $_POST['idCalled'];
                        $description = $_POST['description'];
                        $idTechnician = $_POST['idTechnician'];
                        $matriculaTechnician = $_POST['matriculaTechnician'];

                        $techniciansCalled = new TechniciansCalled();
                        if ($techniciansCalled->updateDetail($idCalled, $idTechnician, $matriculaTechnician, $description)) {
                            echo "<p class='text-green-500 mt-5'>Detalhe atualizado com sucesso!</p>";
                        } else {
                            echo "<p class='text-red-500 mt-5'>Erro ao atualizar o detalhe do chamado.</p>";
                        }
                    }
                    ?>
                </section>
            <?php } ?>

            </main>
</body>

</html>