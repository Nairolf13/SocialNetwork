<?php

class LikeController extends Controller
{
    public function index()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['like_post']) && isset($_SESSION['user_id'])) {
                $projectId = intval($_POST['like_post']);
                $userId = $_SESSION['user_id'];

                try {
                    $this->addLike($projectId, $userId);
                    header('Location: /main');
                    exit;
                } catch (Exception $e) {
                    // Stocker l'erreur dans la session
                    $_SESSION['error'] = "Erreur lors du traitement du like : " . $e->getMessage();
                    header('Location: /main');
                    exit;
                }
            } else {
                // Gérer le cas où l'ID du projet ou de l'utilisateur est manquant
                $_SESSION['error'] = "Identifiant du projet ou utilisateur manquant.";
                header('Location: /main');
                exit;
            }
        }
    }

    public function addLike($project_id, $user_id)
    {
        if (empty($project_id) || empty($user_id)) {
            throw new Exception("Identifiants du projet ou de l'utilisateur manquants.");
        }

        if (LikeRepository::hasLiked($project_id, $user_id)) {
            LikeRepository::removeLike($project_id, $user_id);
            throw new Exception("L'utilisateur a déjà aimé ce projet. Le like a été retiré.");
        }

        if (LikeRepository::addLike($project_id, $user_id)) {
            return "Like ajouté avec succès.";
        } else {
            throw new Exception("Erreur lors de l'ajout du like.");
        }
    }

    public function removeLike($project_id, $user_id)
    {
        if (empty($project_id) || empty($user_id)) {
            throw new Exception("Identifiants du projet ou de l'utilisateur manquants.");
        }

        if (LikeRepository::removeLike($project_id, $user_id)) {
            return "Like supprimé avec succès.";
        } else {
            throw new Exception("Erreur lors de la suppression du like.");
        }
    }

    public function getLikesCount($project_id)
    {
        if (empty($project_id)) {
            throw new Exception("Identifiant du projet manquant.");
        }

        $count = LikeRepository::getLikesCount($project_id);
        return $count;
    }

    public function getLikesByPost($project_id)
    {
        if (empty($project_id)) {
            throw new Exception("Identifiant du projet manquant.");
        }

        $likes = LikeRepository::getLikesByPost($project_id);
        return $likes;
    }
}
