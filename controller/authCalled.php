<?php

require_once '../model/tectechniciansCallled.php';

class CalledTechnicians
{

    // Verifica se o técnico está autenticado
    private function isAuthenticated()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        return isset($_SESSION['user']['matricula']) && isset($_SESSION['token']);
    }

    public function Detail($idCalled, $idTechnician, $matriculaTechnician, $description)
    {
        if (!$this->isAuthenticated() || $_SESSION['user']['matricula'] !== $matriculaTechnician) {
            echo "Acesso negado! Técnico não autenticado.";
            return false;
        }

        $calledTechniciansModel = new TechniciansCalled();
        if ($calledTechniciansModel->createDetail($idCalled, $idTechnician, $matriculaTechnician, $description)) {
            echo "Detalhamento criado com sucesso!";
            return true;
        } else {
            echo "Erro ao criar detalhamento!";
            return false;
        }
    }

    public function Status($idCalled, $newStatus)
    {
        if (!$this->isAuthenticated()) {
            echo "Acesso negado! Técnico não autenticado.";
            return false;
        }

        $calledTechniciansModel = new TechniciansCalled();
        if ($calledTechniciansModel->updateStatus($idCalled, $newStatus)) {
            return true;
        } else {
            return false;
        }
    }

    public function UpdateDetailTec($idCalled, $idTechnician, $matriculaTechnician, $description)
    {
        if (!$this->isAuthenticated() || $_SESSION['user']['matricula'] !== $matriculaTechnician) {
            echo "Acesso negado! Técnico não autenticado.";
            return false;
        }

        $calledTechniciansModel = new TechniciansCalled();
        if ($calledTechniciansModel->updateDetail($idCalled, $idTechnician, $matriculaTechnician, $description)) {
            return true;
        } else {
            return false;
        }
    }

    public function tecGetDetails($idCalled)
    {
        if (!$this->isAuthenticated()) {
            echo "Acesso negado! Técnico não autenticado.";
            return false;
        }

        $calledTechniciansModel = new TechniciansCalled();
        $details = $calledTechniciansModel->getDetailsTec($idCalled);
        return $details;
    }

    public function listCalledsByUser($idUser)
    {
        if (!$this->isAuthenticated()) {
            echo "Acesso negado! Técnico não autenticado.";
            return false;
        }

        $calledTechniciansModel = new TechniciansCalled();
        $calleds = $calledTechniciansModel->listCalledsByUser($idUser);
        return $calleds;
    }

    public function listCalledsByTechnician($idTechnician)
    {
        if (!$this->isAuthenticated()) {
            echo "Acesso negado! Técnico não autenticado.";
            return false;
        }

        $calledTechniciansModel = new TechniciansCalled();
        $calleds = $calledTechniciansModel->listCalledsByTechnician($idTechnician);
        return $calleds;
    }

    public function listAllCalleds()
    {
        if (!$this->isAuthenticated()) {
            echo "Acesso negado! Técnico não autenticado.";
            return false;
        }

        $calledTechniciansModel = new TechniciansCalled();
        $calleds = $calledTechniciansModel->listAllCalleds();
        return $calleds;
    }

    public function createCalled($idUser, $codeCalled, $description, $estatus = "active")
    {
        if (!$this->isAuthenticated()) {
            echo "Acesso negado! Técnico não autenticado.";
            return false;
        }

        $calledTechniciansModel = new TechniciansCalled();
        if ($calledTechniciansModel->createCalled($idUser, $codeCalled, $description, $estatus)) {
            echo "Chamado criado com sucesso!";
            return true;
        } else {
            echo "Erro ao criar chamado!";
            return false;
        }
    }

    public function deleteCalled($idCalled)
    {
        if (!$this->isAuthenticated()) {
            echo "Acesso negado! Técnico não autenticado.";
            return false;
        }

        $calledTechniciansModel = new TechniciansCalled();
        if ($calledTechniciansModel->deleteCalled($idCalled)) {
            echo "Chamado deletado com sucesso!";
            return true;
        } else {
            echo "Erro ao deletar chamado!";
            return false;
        }
    }

    public function acceptCalled($idCalled, $idTechnician, $matriculaTechnician)
    {
        if (!$this->isAuthenticated()) {
            echo "Acesso negado! Técnico não autenticado.";
            return false;
        }

        $calledTechniciansModel = new TechniciansCalled();
        if ($calledTechniciansModel->acceptCalled($idCalled, $idTechnician, $matriculaTechnician)) {
            return true;
        } else {
            return false;
        }
    }
}

// Roteamento básico usando POST
// if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
//     $authController = new CalledTechnicians();
//     $action = $_POST['action'];

//     if (method_exists($authController, $action)) {
//         $authController->$action();
//     } else {
//         echo "Ação inválida!";
//     }
// } else {
//     echo "Nenhuma ação especificada ou método inválido!";
// }
