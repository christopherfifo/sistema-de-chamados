<?php

require_once '../factory/conexao.php';

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
        $sql = "INSERT INTO Calleds (id_user, description) VALUES (:id_user, :description)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        return $stmt->execute();
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

    //lista todos os chamados relacionados ao usuário
    public function listCalleds($id_user)
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
                  WHERE c.id_user = ?";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$id_user]);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result ? $result : null; // Retorna os detalhes ou null se não existir
        } catch (PDOException $e) {
            error_log("Erro ao obter detalhes do chamado: " . $e->getMessage());
            return false;
        }
    }

    // cancela um chamado
    public function cancelCalled($idCalled, $status)
    {
        if ($status !== "CANCELADO") {
            return false; // Retorna false se o status não for CANCELADO
        }

        try {
            $query = "UPDATE Calleds SET estatus = ? WHERE id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$status, $idCalled]); // Corrige a ordem dos parâmetros
            return $stmt->rowCount() > 0; // Retorna true se a atualização afetar pelo menos uma linha
        } catch (PDOException $e) {
            error_log("Erro ao cancelar chamado: " . $e->getMessage());
            return false; // Retorna false em caso de erro
        }
    }
}
