<?php
class RegisterController extends Controller
{
    public function index()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!empty($_POST["username"]) && !empty($_POST["email"]) && !empty($_POST["password"]) && !empty($_POST["confirm_password"])) {
                $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
                $password = $_POST['password'];
                
                if ($username && $email && $password) {
                    if ($password === $_POST['confirm_password']) {
                        $user = new User($_POST['username'], $_POST['email'], $_POST['password'], $_POST['confirm_password']);
                        User::postUser($user); 
                        header('Location: /login');
                        exit();
                    } else {
                        $_SESSION['error'] = "Les mots de passe ne correspondent pas.";
                    }
                } else {
                    if (!$email) {
                        $_SESSION['error'] = "Veuillez entrer une adresse email valide.";
                    } else {
                        $_SESSION['error'] = "Veuillez remplir tous les champs correctement.";
                    }
                }
            }
            if (isset($_POST['action']) && $_POST['action'] == 'delete') {
                $user = $_POST['id'];
             
                try {
                    if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])){
                        UserRepository::deleteUser($_SESSION['user_id']);
                        require(__DIR__."/../../views/Register.php");
                        exit();
                    }
                } catch (PDOException $e) {
                    $_SESSION['error'] = "Erreur lors de la suppression du compte : " . $e->getMessage();
                    header("Location: /error");
                    exit();
                }
            }
        }
    
        if (isset($_SESSION['error'])) {
            $error = $_SESSION['error'];
            unset($_SESSION['error']);
        } else {
            $error = '';
        }
        
        require_once(__DIR__ . "/../../views/Register.php");
    }
}
?>
