<?php

class User extends UserRepository
{
    private $id;
    private $username;
    private $email;
    private $password;
    private $confirmPassword;

    public function __construct($username, $email, $password, $confirm_password, $id = null)
    {
        if ($username && $email && $password && $confirm_password) {
            if (isset($id)) {
                $this->id = htmlspecialchars($id);
            }
            $this->setUsername($username);
            $this->setEmail($email);

           
            if ($password === $confirm_password) {
                $this->setPassword($password); 
            } else {
                header("Location: /register" );
                exit();
            }
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getConfirmPassword()
    {
        return $this->confirmPassword;
    }

    public function setUsername($username)
    {
        $this->username = htmlspecialchars($username);
        if (strlen($username) < 3) {
            header("Location: /register");
            exit();
        }
    }

    public function setEmail($email)
    {
        $this->email = htmlspecialchars($email);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            header("Location: /register" );
            exit();
        }

       
        $email_regex = '/^[a-zA-Z0-9.!#$%&\'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/';
        if (!preg_match($email_regex, $email)) {
            header("Location: /register" );
            exit();
        }
    }

    public function setPassword($password)
    {
     
        $password_regex = '/^(?=.*[A-Z])(?=.*[0-9])(?=.*[\W_]).{8,}$/';
        if (!preg_match($password_regex, $password)) {
            header("Location: /register");
            exit();
        }

       
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    public function setConfirmPassword($confirm_password)
    {
        $this->confirmPassword = htmlspecialchars($confirm_password);
    }

   
    public static function login($username, $password)
    {
        $user = self::getUsername($username); 
        if ($user && password_verify($password, $user['password'])) {
           
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            return true;
        }
        return false;
    }
}
?>
