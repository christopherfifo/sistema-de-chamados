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
}
?>