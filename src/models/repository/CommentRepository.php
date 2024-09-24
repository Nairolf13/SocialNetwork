<?php

abstract class CommentRepository extends Db
{
    public static function addComment($project_id, $user_id, $content)
    {
        $sql = "INSERT INTO comments (project_id, user_id, content) VALUES (:project_id, :user_id, :content)";

        $stmt = self::getInstance()->prepare($sql);
        $stmt->bindParam(':project_id', $project_id, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':content', $content, PDO::PARAM_STR);

        if (!$stmt->execute()) {

            $error = $stmt->errorInfo();
            echo "SQL Error: " . $error;
            return false;
        }

        return true;
    }

    public static function updateComment($id, $content)
    {
        $sql = "UPDATE comments SET content = :content WHERE id = :id";

        $stmt = self::getInstance()->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':content', $content, PDO::PARAM_STR);

        if (!$stmt->execute()) {
            $error = $stmt->errorInfo();
            echo "SQL Error: " . $error;
            return false;
        }

        return true;
    }

    public static function deleteComment($commentId, $userId)
    {
        $sql = "DELETE FROM comments WHERE id = :id AND user_id = :user_id";
        $db = self::getInstance();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $commentId, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public static function getCommentsByPost($project_id)
    {
        $sql = "SELECT comments.*, users.username AS user_name 
            FROM comments 
            JOIN users ON comments.user_id = users.id 
            WHERE comments.project_id = :project_id 
            ORDER BY comments.created_at DESC";

        $stmt = self::getInstance()->prepare($sql);
        $stmt->bindParam(':project_id', $project_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getCommentById($id)
    {
        $sql = "SELECT * FROM comments WHERE id = :id";

        $stmt = self::getInstance()->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function updateCommentCount($project_id)
    {
        $currentCount = self::getCommentCount($project_id);
        $newCount = $currentCount + 1;

        $sql = "UPDATE projects SET comments_count = :comments_count WHERE id = :project_id";

        $stmt = self::getInstance()->prepare($sql);
        $stmt->bindParam(':comments_count', $newCount, PDO::PARAM_INT);
        $stmt->bindParam(':project_id', $project_id, PDO::PARAM_INT);

        if (!$stmt->execute()) {

            $error = $stmt->errorInfo();
            echo "SQL Error: " . $error;
            return false;
        }

        return true;
    }

    public static function getCommentCount($project_id)
    {
        $sql = "SELECT COUNT(*) AS count FROM comments WHERE project_id = :project_id";

        $stmt = self::getInstance()->prepare($sql);
        $stmt->bindParam(':project_id', $project_id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int) $result['count'];
    }
}
