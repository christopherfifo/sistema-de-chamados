<?php
require_once 'factory/conexao.php';

class Conflitos
{
    private $conn;

    public function __construct()
    {
        $this->conn = new Conexao();
    }

    public function getConflitos($idCalled)
    {
        $sql = "SELECT code_called FROM Calleds";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}

?>