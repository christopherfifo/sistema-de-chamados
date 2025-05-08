<?php

require_once '../factory/conexao.php';

class TechniciansCalled
{
    private $db;

    public function __construct()
    {
        $dbInstance = new Caminho();
        $this->db = $dbInstance->getConn();
    }

    // Cria o detalhamento do chamado
    public function createDetail($idCalled, $idTechnician, $matriculaTechnician, $description)
    {

        try {
            $query = "INSERT INTO Calleds_technicians (id_called, id_technician, matricula_technician, description) 
                      VALUES (?, ?, ?, ?)";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$idCalled, $idTechnician, $matriculaTechnician, $description]);
            return true; // Detalhamento criado com sucesso
        } catch (PDOException $e) {
            error_log("Erro ao criar detalhamento do chamado: " . $e->getMessage());
            return false;
        }
    }

    public function updateDetail($idCalled, $idTechnician, $matriculaTechnician, $description)
    {

        try {
            $query = "UPDATE Calleds_technicians SET description = ? WHERE id_called = ? AND id_technician = ? AND matricula_technician = ?";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$description, $idCalled, $idTechnician, $matriculaTechnician]);
            return true; // Detalhamento criado com sucesso
        } catch (PDOException $e) {
            error_log("Erro ao atualizar o detalhamento " . $e->getMessage());
            return false;
        }
    }


    public function updateStatus($idCalled, $newStatus)
    {

        try {
            $query = "UPDATE Calleds SET estatus = ? WHERE id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$newStatus, $idCalled]);
            return true;
        } catch (PDOException $e) {
            error_log("Erro ao atualizar status do chamado: " . $e->getMessage());
            return false;
        }
    }

    public function getDetailsTec($idCalled)
    {
        try {
            $query = "SELECT 
                c.id AS called_id, 
                c.code_called, 
                c.description AS called_description, 
                c.estatus AS called_status, 
                ct.id AS detail_id, 
                ct.id_technician, 
                ct.matricula_technician, 
                ct.description AS detail_description, 
                u.name AS client_name 
                  FROM Calleds c
                  LEFT JOIN Calleds_technicians ct ON c.id = ct.id_called
                  LEFT JOIN Users u ON c.id_user = u.id
                  WHERE c.id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$idCalled]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ? $result : null; // Retorna os detalhes ou null se não existir
        } catch (PDOException $e) {
            error_log("Erro ao obter detalhes do chamado: " . $e->getMessage());
            return false;
        }
    }

    // lista todos os chamados
    public function listAllCalleds()
    {
        try {
            $query = "SELECT * FROM Calleds";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retorna todos os chamados
        } catch (PDOException $e) {
            error_log("Erro ao listar chamados: " . $e->getMessage());
            return false;
        }
    }

    // lista os chamados por usuario
    public function listCalledsByUser($idUser)
    {
        try {
            $query = "SELECT * FROM Calleds WHERE id_user = ?";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$idUser]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retorna todos os chamados do usuário
        } catch (PDOException $e) {
            error_log("Erro ao listar chamados do usuário: " . $e->getMessage());
            return false;
        }
    }

    // lista os chamados por tecnico
    public function listCalledsByTechnician($idTechnician)
    {
        try {
            $query = "SELECT * FROM Calleds_technicians WHERE id_technician = ?";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$idTechnician]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retorna todos os chamados do técnico
        } catch (PDOException $e) {
            error_log("Erro ao listar chamados do técnico: " . $e->getMessage());
            return false;
        }
    }

    //criar um chamado
    public function createCalled($idUser, $codeCalled, $description, $estatus = "active")
    {
        try {
            $query = "INSERT INTO Calleds (id_user, code_called, description, estatus) 
                      VALUES (?, ?, ?, ?)";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$idUser, $codeCalled, $description, $estatus]);
            return true; // Chamado criado com sucesso
        } catch (PDOException $e) {
            error_log("Erro ao criar chamado: " . $e->getMessage());
            return false;
        }
    }


    // lista os tecnicos
    public function listAllTechnicians()
    {
        try {
            $query = "SELECT * FROM Tectechnicians";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retorna todos os tecnicos
        } catch (PDOException $e) {
            error_log("Erro ao listar tecnicos: " . $e->getMessage());
            return false;
        }
    }

    // deletar um chamado
    public function deleteCalled($idCalled)
    {
        try {
            $query = "DELETE FROM Calleds WHERE id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$idCalled]);
            return true; // Chamado deletado com sucesso
        } catch (PDOException $e) {
            error_log("Erro ao deletar chamado: " . $e->getMessage());
            return false;
        }
    }

    // aceitar um chamado
    /*
CREATE TABLE IF NOT EXISTS Calleds(
    id INT AUTO_INCREMENT primary key,
    id_user INT NOT NULL,
    code_called INT NOT NULL UNIQUE,
    description VARCHAR(255) NOT NULL,
    estatus VARCHAR(255) NOT NULL DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_user) REFERENCES Users(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS Calleds_technicians(
    id INT AUTO_INCREMENT primary key,
    id_called INT NOT NULL,
    id_technician INT NOT NULL,
    matricula_technician VARCHAR(255) NOT NULL,
    description VARCHAR(255) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_called) REFERENCES Calleds(id) ON DELETE CASCADE,
    FOREIGN KEY (id_technician) REFERENCES Technicians(id) ON DELETE CASCADE
);

    */
    // criar entrada na tabela calleds_technicians
    public function acceptCalled($idCalled, $idTechnician, $matriculaTechnician)
    {
        try {
            $query = "INSERT INTO Calleds_technicians (id_called, id_technician, matricula_technician) 
                      VALUES (?, ?, ?)";
            echo "<script>console.log('Chamado aceito: id_called = " . $idCalled . ", id_technician = " . $idTechnician . ", matricula_technician = " . $matriculaTechnician . "');</script>";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$idCalled, $idTechnician, $matriculaTechnician]);
            // log query to console

            return true; // Chamado aceito com sucesso
        } catch (PDOException $e) {
            error_log("Erro ao aceitar chamado: " . $e->getMessage());
            // log to console
            echo "<script>console.log('Erro ao aceitar chamado: " . $e->getMessage() . "');</script>";
            return false;
        }
    }
}
