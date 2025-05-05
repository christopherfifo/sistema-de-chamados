<?php

require_once '../factory/conexao.php';

class TectechniciansModel
{
    private $db;

    public function __construct()
    {
        $dbInstance = new Caminho();
        $this->db = $dbInstance->getConn();
    }

    public function login($matricula, $password)
    {
        try {
            // Prepara a consulta SQL
            $stmt = $this->db->prepare("SELECT * FROM Tectechnicians WHERE matricula = :matricula");
            $stmt->bindParam(':matricula', $matricula, PDO::PARAM_STR);
            $stmt->execute();

            // Busca o usuário
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verifica se o usuário existe e a senha está correta
            if ($user && password_verify($password, $user['password'])) {
                return $user; // Retorna os dados do usuário
            }
        } catch (PDOException $e) {
            // Trata erros de banco de dados
            error_log("Erro no login: " . $e->getMessage());
        }

        return false; // Falha no login
    }
}
