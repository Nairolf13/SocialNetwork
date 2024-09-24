<?php

class CommentController extends Controller
{
    public function index()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            $userId = $_SESSION['user_id'] ?? null;

            if (isset($_POST['delete_comment']) && !empty($_POST['delete_comment'])) {
                $commentId = filter_input(INPUT_POST, 'delete_comment', FILTER_VALIDATE_INT);

                if (empty($commentId) || empty($userId)) {
                    $_SESSION['error'] = "Identifiant du commentaire ou de l'utilisateur manquant.";
                    header('Location: /main');
                    exit;
                }

                try {
                    $this->deleteComment($commentId, $userId);
                    header('Location: /main');
                    exit;
                } catch (Exception $e) {
                    error_log($e->getMessage());
                    $_SESSION['error'] = "Une erreur est survenue lors de la suppression du commentaire.";
                    header('Location: /main');
                    exit;
                }
            }

            $projectId = filter_input(INPUT_POST, 'project_id', FILTER_VALIDATE_INT);
            $content = $_POST['content'] ?? '';

            if ($projectId === false || empty($userId) || empty($content)) {
                $_SESSION['error'] = "Identifiant du projet, utilisateur, ou contenu manquant.";
                header('Location: /main');
                exit;
            }

            try {
                $this->addComment($projectId, $userId, $content);
                header('Location: /main');
                exit;
            } catch (Exception $e) {
                error_log($e->getMessage());
                $_SESSION['error'] = "Une erreur est survenue lors de l'ajout du commentaire.";
                header('Location: /main');
                exit;
            }
        }
    }

    public function addComment($project_id, $user_id, $content)
    {
        if (empty($project_id) || empty($user_id) || empty($content)) {
            throw new Exception("Tous les champs doivent être remplis.");
        }

        try {
            CommentRepository::addComment($project_id, $user_id, htmlspecialchars($content));
        } catch (Exception $e) {
            throw new Exception("Erreur lors de l'ajout du commentaire.");
        }
    }

    public function deleteComment($comment_id, $user_id)
    {
        if (empty($comment_id) || empty($user_id)) {
            throw new Exception("Identifiant du commentaire ou de l'utilisateur manquant.");
        }

        $comment = CommentRepository::getCommentById($comment_id);

        if ($comment['user_id'] != $user_id) {
            throw new Exception("Vous n'avez pas le droit de supprimer ce commentaire.");
        }

        if (!CommentRepository::deleteComment($comment_id, $user_id)) {
            throw new Exception("Erreur lors de la suppression du commentaire.");
        }
    }

    public function getCommentsByPost($project_id)
    {
        if (empty($project_id)) {
            throw new Exception("Identifiant du post manquant.");
        }

        return CommentRepository::getCommentsByPost($project_id);
    }
}
