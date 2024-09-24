<?php

abstract class UserRepository extends Db
{

    private static function request($request, $params = [])
    {
        $db = self::getInstance();
        $stmt = $db->prepare($request);
        $stmt->execute($params);
        self::disconnect();
        return $stmt;
    }

    public static function postUser(User $userdata)
    {

        $sql = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
        $params = [
            'username' => $userdata->getUsername(),
            'email' => $userdata->getEmail(),
            'password' => $userdata->getPassword()
        ];

        self::request($sql, $params);
    }

    public static function updateUser($userData)
    {
        unset($userData['password']);
        
        self::request("UPDATE users SET username = :username, email = :email  WHERE id = :id", $userData);
    }

    public static function updatePass($password, $id)
    {
        self::request("UPDATE users SET password = '$password' WHERE id = '$id'");
    }

    public static function deleteUser($id)
    {
        self::request("DELETE FROM users WHERE id = :id", ['id' => $id]);
    }

    public static function getUserById($id)
    {
        $stmt = self::getInstance()->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);

        return $userData;
    }

    public static function getUserByName($name)
    {
        $stmt = self::getInstance()->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(':username', $name);
        $stmt->execute();
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);
        return $userData;

        return null;
    }
}
