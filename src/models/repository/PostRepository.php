<?php

abstract class PostRepository extends Db
{

    public static function CreatePost(Post $postData)
    {

        $sql = "INSERT INTO projects (title, image ,description, user_id) VALUES (:title, :image ,:description, :user_id)";

        $title = $postData->getTitle();
        $description = $postData->getDescription();
        $image = $postData->getImage();
        $user_id = $postData->getUserId();

        $db = self::getInstance();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':image', $image);


        $stmt->execute();

        self::disconnect();
    }

    public static function updateProjects(Post $postData)
    {
        $sql = "UPDATE projects SET title = :title, description = :description";

        if ($postData->getImage() !== null) {
            $sql .= ", image = :image";
        }

        $sql .= " WHERE id = :id";

        $title = $postData->getTitle();
        $description = $postData->getDescription();
        $image = $postData->getImage();
        $project_id = $postData->getId();

        $db = self::getInstance();
        $stmt = $db->prepare($sql);

        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);

        if ($image !== null) {
            $stmt->bindParam(':image', $image, PDO::PARAM_LOB);
        }

        $stmt->bindParam(':id', $project_id, PDO::PARAM_INT);

        $stmt->execute();

        self::disconnect();
    }



    public static function deletePost($project_id)
    {
        $sql = "DELETE FROM projects WHERE id = :id";

        $db = self::getInstance();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $project_id, PDO::PARAM_INT);
        $stmt->execute();

        self::disconnect();
    }

    public static function getAllProjects()
    {
        $sql = "SELECT projects.*, users.username 
                FROM projects 
                JOIN users ON projects.user_id = users.id 
                ORDER BY projects.created_at DESC";
        
        $db = self::getInstance();
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        self::disconnect();
        return $projects;
    }
    

    public static function getPostById($postId)
    {
        $sql = "SELECT * FROM projects WHERE id = :id";
        $db = self::getInstance();
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $postId = $stmt->fetch(PDO::FETCH_ASSOC);
        return $postId;
    }

    public function getImageById($imageId)
    {
        $sql = "SELECT image, title FROM projects WHERE id = :id";
        $db = self::getInstance();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $imageId, PDO::PARAM_INT);
        $stmt->execute();
        $imageData = $stmt->fetch(PDO::FETCH_ASSOC);
        return $imageData;
    }
    
}
