<?php

class UpdateController extends Controller {
    public function index() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($_POST['action'] == 'update') {
                $user = [
                    'id' => $_SESSION['user_id'],
                    'username' => $_POST['username'],
                    "email" => $_POST['email'],
                    "password" => $_POST['password'],
                ];
             
                try {
                    if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
                        UserRepository::updateUser($user);
                        header("Location: /main");
                        exit();
                    }
                } catch (PDOException $e) {
                    $_SESSION['error'] = "Erreur lors de la modification du compte : " . $e->getMessage();
                    header("Location: /main");
                    exit();
                }
            }

            if ($_POST['action'] == "updatemdp") {
                $user = User::getUserById($_SESSION['user_id']);
                if (password_verify($_POST['old_password'], $user['password'])) {
                    User::updatePass(password_hash($_POST['new_password'], PASSWORD_DEFAULT), $_SESSION['user_id']);
                    header("Location: /main");
                    exit();
                } else {
                    $_SESSION['error'] = "Ancien mot de passe incorrect.";
                    header("Location: /main");
                    exit();
                }
            }
        }
    }
}
?>
