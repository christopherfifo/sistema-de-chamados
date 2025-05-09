<?php
require_once '../model/userModel.php';
require_once '../model/tectechniciansModel.php';

session_start();

class AuthControllerClient
{
    public function register()
    {
        header('Content-Type: application/json'); // Garante que o conteúdo seja JSON
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $cpf = $_POST['cpf'];
            $email = $_POST['email'];
            $telephone = $_POST['telephone'];
            $password = $_POST['password'];

            $userModel = new userModel();

            // Verifica se o email já existe
            if ($userModel->confereEmail($email)) {
                echo json_encode(['error' => 'Email já cadastrado!']);
                return;
            }

            // Verifica se o CPF já existe
            if ($userModel->confereCpf($cpf)) {
                echo json_encode(['error' => 'CPF já cadastrado!']);
                return;
            }

            if ($userModel->register($name, $cpf, $email, $telephone, $password)) {
                $user = $userModel->login($email, $password);
                if ($user) {
                    $_SESSION['user'] = $user;
                    echo json_encode(['success' => 'Cadastro realizado com sucesso!']);
                } else {
                    echo json_encode(['error' => 'Credenciais inválidas!']);
                }
            } else {
                echo json_encode(['error' => 'Erro ao registrar usuário.']);
            }
        } else {
            echo json_encode(['error' => 'Método não permitido.']);
        }
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['usuario'];
            $password = $_POST['password'];

            $userModel = new UserModel();
            $user = $userModel->login($email, $password);
            if ($user) {
                $_SESSION['user'] = $user;
                $token = bin2hex(random_bytes(32));
                $_SESSION['token'] = $token;
                header('Location: ../view/userCalledsPage.php');
            } else {
                echo "Credenciais inválidas!";
            }
        }
    }

    public function Tectechnicians_login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $matricula = $_POST['usuario'];
            $password = $_POST['password'];

            $tectechniciansModel = new TectechniciansModel();
            $user = $tectechniciansModel->login($matricula, $password);
            if ($user) {
                $_SESSION['user'] = $user;
                $token = bin2hex(random_bytes(32));
                $_SESSION['token'] = $token;
                header('Location: ../view/chamados.php');
            } else {
                echo "Credenciais inválidas!";
            }
        }
    }
}

// Roteamento básico usando POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $authController = new AuthControllerClient();
    $action = $_POST['action'];

    if ($action != "register") {
    }

    if (method_exists($authController, $action)) {
        $authController->$action();
    } else {
        echo "Ação inválida!";
    }
} else {
    echo "Nenhuma ação especificada ou método inválido!";
}
