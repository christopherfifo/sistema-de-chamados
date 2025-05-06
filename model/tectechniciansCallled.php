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
            $stmt->execute([$idCalled, $idTechnician, $matriculaTechnician, $description]);
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
}
