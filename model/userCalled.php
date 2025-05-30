<?php

require_once '../factory/conexao.php';
require_once '../factory/resolveConflitos.php';

class userCalled
{
    private $db;

    public function __construct()
    {
        $dbInstance = new Caminho();
        $this->db = $dbInstance->getConn();
    }

    public function createCalled($id_user, $description)
    {
        $teste = new ResolveConflitos();
        $code_called = $teste->getNovoCodeCalled();
        $sql = "INSERT INTO Calleds (id_user, code_called, description) VALUES (:id_user, :code_called, :description)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
        $stmt->bindParam(':code_called', $code_called, PDO::PARAM_INT);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        return $stmt->execute();
    }

    //pegar um chamado específico
    public function getCalled($idCalled, $id_user)
    {
        try {
            $query = "SELECT * FROM Calleds WHERE id = ? AND id_user = ?";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$idCalled, $id_user]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ? $result : null; // Retorna o chamado ou null se não existir
        } catch (PDOException $e) {
            error_log("Erro ao obter chamado: " . $e->getMessage());
            return false;
        }
    }

    public function getDetailsUSer($idCalled)
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

    public function getDetailsUSerCalled($idCalled)
    {
        try {
            $query = "SELECT t.id, t.name, t.cpf, ct.description
                    FROM Calleds_technicians ct
                    INNER JOIN Technicians t ON ct.id_technician = t.id
                    WHERE ct.id_called = ?";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$idCalled]);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result ? $result : null;
        } catch (PDOException $e) {
            error_log("Erro ao obter dados simples do técnico: " . $e->getMessage());
            return false;
        }
    }

// Lista todos os chamados relacionados ao usuário sem apelidos nos campos
public function listCalleds($id_user)
{
    try {
        $query = "SELECT * FROM Calleds WHERE id_user = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id_user]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result ? $result : null; // Retorna os detalhes ou null se não existir
    } catch (PDOException $e) {
        error_log("Erro ao obter detalhes do chamado: " . $e->getMessage());
        return false;
    }
}

    // Cancela um chamado
    public function cancelCalled($idCalled, $status)
    {
        if ($status !== "Fechado") { // Corrige a verificação do status para "Cancelado"
            return false; // Retorna false se o status não for "Cancelado"
        }

        try {
            $query = "UPDATE Calleds SET estatus = :status WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':status', $status, PDO::PARAM_STR);
            $stmt->bindParam(':id', $idCalled, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->rowCount() > 0; // Retorna true se a atualização afetar pelo menos uma linha
        } catch (PDOException $e) {
            error_log("Erro ao cancelar chamado: " . $e->getMessage());
            return false; // Retorna false em caso de erro
        }
    }
}
