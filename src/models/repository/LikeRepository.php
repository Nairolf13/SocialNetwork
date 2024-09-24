<?php

abstract class LikeRepository extends Db
{
    public static function addLike($project_id, $user_id)
    {
        $sql = "INSERT INTO likes (project_id, user_id) VALUES (:project_id, :user_id)";

        $stmt = self::getInstance()->prepare($sql);
        $stmt->bindParam(':project_id', $project_id, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public static function removeLike($project_id, $user_id)
    {
        $sql = "DELETE FROM likes WHERE project_id = :project_id AND user_id = :user_id";

        $stmt = self::getInstance()->prepare($sql);
        $stmt->bindParam(':project_id', $project_id, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public static function hasLiked($project_id, $user_id)
    {
        $sql = "SELECT COUNT(*) FROM likes WHERE project_id = :project_id AND user_id = :user_id";

        $stmt = self::getInstance()->prepare($sql);
        $stmt->bindParam(':project_id', $project_id, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchColumn() > 0;
    }

    public static function getLikesCount($project_id)
    {
        $sql = "SELECT COUNT(*) FROM likes WHERE project_id = :project_id";

        $stmt = self::getInstance()->prepare($sql);
        $stmt->bindParam(':project_id', $project_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchColumn();
    }

    public static function getLikesByPost($project_id)
    {
        $sql = "SELECT user_id FROM likes WHERE project_id = :project_id";

        $stmt = self::getInstance()->prepare($sql);
        $stmt->bindParam(':project_id', $project_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
