<?php

require_once '../model/tectechniciansCallled.php';

class CalledTechnicians {

    // Verifica se o técnico está autenticado
    private function isAuthenticated() {
        session_start();
        return isset($_SESSION['user']['matricula']) && isset($_SESSION['token']);
    }

    public function Detail($idCalled, $idTechnician, $matriculaTechnician, $description) {
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

    public function Status($idCalled, $newStatus) {
        if (!$this->isAuthenticated()) {
            echo "Acesso negado! Técnico não autenticado.";
            return false;
        }

        $calledTechniciansModel = new TechniciansCalled();
        if ($calledTechniciansModel->updateStatus($idCalled, $newStatus)) {
            echo "Status atualizado com sucesso!";
            return true;
        } else {
            echo "Erro ao atualizar status!";
            return false;
        }
    }

    public function UpdateDetailTec($idCalled, $idTechnician, $matriculaTechnician, $description) {
        if (!$this->isAuthenticated() || $_SESSION['user']['matricula'] !== $matriculaTechnician) {
            echo "Acesso negado! Técnico não autenticado.";
            return false;
        }

        $calledTechniciansModel = new TechniciansCalled();
        if ($calledTechniciansModel->updateDetail($idCalled, $idTechnician, $matriculaTechnician, $description)) {
            echo "Detalhamento atualizado com sucesso!";
            return true;
        } else {
            echo "Erro ao atualizar detalhamento!";
            return false;
        }
    }

    public function tecGetDetails($idCalled) {
        if (!$this->isAuthenticated()) {
            echo "Acesso negado! Técnico não autenticado.";
            return false;
        }

        $calledTechniciansModel = new TechniciansCalled();
        $details = $calledTechniciansModel->getDetailsTec($idCalled);
        return $details;
    }
}
?>