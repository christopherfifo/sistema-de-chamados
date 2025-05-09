<?php 

require_once '../factory/conexao.php';

class UserModel {

    private $db;

    public function __construct() {
        $dbInstance = new Caminho();
        $this->db = $dbInstance->getConn(); 
    }

    public function confereEmail($email) {
        try {
            $query = "SELECT * FROM Users WHERE email = ?";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$email]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return !empty($result); // Retorna true se o email já existe
        } catch (PDOException $e) {
            error_log("Erro ao verificar email: " . $e->getMessage());
            return false;
        }
    }

    public function confereCpf($cpf) {
        try {
            $query = "SELECT * FROM Users WHERE cpf = ?";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$cpf]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return !empty($result); // Retorna true se o CPF já existe
        } catch (PDOException $e) {
            error_log("Erro ao verificar CPF: " . $e->getMessage());
            return false;
        }
    }

    public function register($name, $cpf, $email, $telephone, $password) {
        try {
            $hashedPassword = $password;
            $query = "INSERT INTO Users (name, cpf, email, telephone, password) VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$name, $cpf, $email, $telephone, $hashedPassword]);
            return true; // Registro bem-sucedido
        } catch (PDOException $e) {
            error_log("Erro ao registrar usuário: " . $e->getMessage());
            return false;
        }
    }

    public function login($email, $password) {
        try {
            $query = "SELECT * FROM Users WHERE email = ?";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verifica a senha
    if ($user && $password === $user['password']) {
        return $user;
    }
        } catch (PDOException $e) {
            error_log("Erro ao fazer login: " . $e->getMessage());
        }
        return false; // Falha no login
    }
}
?>