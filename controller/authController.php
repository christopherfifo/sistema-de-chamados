<?php
require_once '../model/userModel.php';

class AuthControllerClient {
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $cpf = $_POST['cpf'];
            $email = $_POST['email'];
            $telephone = $_POST['telephone'];
            $password = $_POST['password'];

            $userModel = new userModel();
            // Verifica se o email já existe
            if ($userModel->confereEmail($email)) {
                echo "Email já cadastrado!";
                return;
            }
            // Verifica se o CPF já existe
            if ($userModel->confereCpf($cpf)) {
                echo "CPF já cadastrado!";
                return;
            }
            if ($userModel->register($name, $cpf, $email, $telephone, $password)) {
                echo "Cadastro realizado com sucesso!";
            } else {
                echo "Erro no cadastro!";
            }
        }
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $userModel = new UserModel();
            $user = $userModel->login($email, $password);
            if ($user) {
                $_SESSION['user'] = $user; 
                header('Location: /dashboard'); 
            } else {
                echo "Credenciais inválidas!";
            }
        }
       
    }
}

// Roteamento básico
if (isset($_GET['action'])) {
    $authController = new AuthControllerClient();
    $action = $_GET['action'];

    if (method_exists($authController, $action)) {
        $authController->$action();
    } else {
        echo "Ação inválida!";
    }
} else {
    echo "Nenhuma ação especificada!";
}
?>