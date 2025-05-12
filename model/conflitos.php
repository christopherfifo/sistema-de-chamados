<?php
require_once '../factory/conexao.php';

class Conflitos
{
    private $conn;

    public function __construct()
    {
        $caminho = new Caminho();
        $this->conn = $caminho->getConn(); // Obtém a conexão PDO corretamente
    }

    public function getConflitos()
    {
        $sql = "SELECT code_called FROM Calleds";
        $stmt = $this->conn->prepare($sql); // Usa a conexão PDO para preparar a consulta
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}
?>