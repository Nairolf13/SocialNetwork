<?php

class LoginController extends Controller
{
    public function index()
    {
        session_start();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['login'])) {
             
                $postUser = [
                    'username' => $_POST['username'],
                    'password' => $_POST['password']
                ];

                if ($postUser['username'] && $postUser['password']) {
                    $user = User::getUserByName($postUser['username']);
                    
                    try {
                        if (isset($user) && password_verify($_POST["password"], $user['password'])) {
                            $_SESSION['user_id'] = $user['id'];
                            $_SESSION['user_name'] = $user['username'];
                            $_SESSION['user_email'] = $user['email'];

                            header('Location: /');
                            exit;
                        } else {
                            throw new Exception("Nom d'utilisateur ou mot de passe incorrect.");
                        }
                    } catch (Exception $e) {
                        $_SESSION['error'] = $e->getMessage();
                        header('Location: /login');
                        exit;
                    }
                } else {
                    $_SESSION['error'] = "Veuillez entrer à la fois un nom d'utilisateur et un mot de passe.";
                    header('Location: /login');
                    exit;
                }
            } 
        }

        require_once(__DIR__ . "/../../views/Login.php");
    }
}
?>
