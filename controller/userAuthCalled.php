<?php
require_once '../model/userCalled.php';

class userAuthCalled {

    // Verifica se o usuário está autenticado
    private function isAuthenticated() {
        session_start();
        return isset($_SESSION['user']['email']) && isset($_SESSION['token']);
    }

    // Cria um chamado
    public function Called($id_user, $description) {
        if (!$this->isAuthenticated()) {
            echo "Acesso negado! Usuário não autenticado.";
            return false;
        }

        $userCalledModel = new userCalled();
        if ($userCalledModel->createCalled($id_user, $description)) {
            echo "Chamado criado com sucesso!";
            return true;
        } else {
            echo "Erro ao criar chamado!";
            return false;
        }
    }

    // Obtém os detalhes do chamado
    public function userGetDetails($idCalled) {
        if (!$this->isAuthenticated()) {
            echo "Acesso negado! Usuário não autenticado.";
            return false;
        }

        $userCalledModel = new userCalled();
        $details = $userCalledModel->getDetailsUSer($idCalled);
        if ($details) {
            return $details;
        } else {
            echo "Erro ao obter detalhes do chamado!";
            return false;
        }
    }

    // Obtém um chamado específico e busca a descrição, se houver
    public function getCalled($idCalled) {
        if (!$this->isAuthenticated()) {
            echo "Acesso negado! Usuário não autenticado.";
            return false;
        }

        $userCalledModel = new userCalled();
        $called = $userCalledModel->getCalled($idCalled);
        if ($called) {
            // Busca a descrição do chamado, se disponível
            $description = $userCalledModel->getDescription($idCalled);
            if ($description) {
                $called['description'] = $description;
            }
            return $called;
        } else {
            echo "Erro ao obter chamado!";
            return false;
        }
    }

    // Lista todos os chamados relacionados ao usuário
    public function listCalleds($id_user) {
        if (!$this->isAuthenticated()) {
            echo "Acesso negado! Usuário não autenticado.";
            return false;
        }

        $userCalledModel = new userCalled();
        $calleds = $userCalledModel->listCalleds($id_user);
        if ($calleds) {
            return $calleds;
        } else {
            echo "Erro ao listar chamados!";
            return false;
        }
    }

    // Cancela um chamado
    public function cancelCalled($idCalled, $status) {
        if (!$this->isAuthenticated()) {
            echo "Acesso negado! Usuário não autenticado.";
            return false;
        }

        if ($status !== "CANCELADO") {
            echo "Status inválido para cancelamento!";
            return false;
        }

        $userCalledModel = new userCalled();
        if ($userCalledModel->cancelCalled($idCalled, $status)) {
            echo "Chamado cancelado com sucesso!";
            return true;
        } else {
            echo "Erro ao cancelar chamado!";
            return false;
        }
    }
}

// Roteamento básico usando POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $authController = new userAuthCalled();
    $action = $_POST['action'];

    if (method_exists($authController, $action)) {
        $authController->$action();
    } else {
        echo "Ação inválida!";
    }
} else {
    echo "Nenhuma ação especificada ou método inválido!";
}
?>