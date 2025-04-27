<?php 
class UserModel {

    public function confereEmail($email) {
        
        $query = "SELECT * FROM users WHERE email = ?";
        $result = $this->db->query($query, [$email]);
        return !empty($result); // Retorna true se o email já existe
    }

    public function confereCpf($cpf) {
        
        $query = "SELECT * FROM users WHERE cpf = ?";
        $result = $this->db->query($query, [$cpf]);
        return !empty($result); // Retorna true se o CPF já existe
    }

    public function register($name, $cpf, $email, $telephone, $password) {
        
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO users (name, cpf, email, telephone, password) VALUES (?, ?, ?, ?, ?)";
        $this->db->query($query, [$name, $cpf, $email, $telephone, $hashedPassword]);
    }

    public function login($email, $password) {
        // Busca usuário no banco
        $user = $this->db->query("SELECT * FROM users WHERE email = ?", [$email]);
        // Verifica a senha
        if ($user && password_verify($password, $user['password'])) {
            return $user; // Retorna dados do usuário
        }
        return false; // Falha no login
    }
}
?>