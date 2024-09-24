<?php

class MainController extends Controller
{
    public function index()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {

            $userId = $_SESSION['user_id'];
            $userData = UserRepository::getUserById($userId);
            $projects = PostRepository::getAllProjects();

            if (!empty($userData)) {
                $userid = $userData['id'];
                $username = $userData['username'];
                $useremail = $userData['email'];
            }

            foreach ($projects as $index => $project) {
                $projectId = $project['id'];
                $projects[$index]['likes_count'] = LikeRepository::getLikesCount($projectId);
                $projects[$index]['comments_count'] = count(CommentRepository::getCommentsByPost($projectId));
            }

            $selectedProjectId = null;
            $selectedComments = [];

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                try {
                    // Gestion des commentaires
                    if (isset($_POST['post_comment_project_id']) && !empty($_POST['post_comment_project_id'])) {
                        $selectedProjectId = intval($_POST['post_comment_project_id']);
                        $selectedComments = CommentRepository::getCommentsByPost($selectedProjectId);
                    }

                    if (isset($_POST['project_id']) && !empty($_POST['project_id']) && isset($_POST['content']) && !empty($_POST['content'])) {
                        $projectId = intval($_POST['project_id']);
                        $userId = $_SESSION['user_id'];
                        $content = htmlspecialchars($_POST['content']);

                        $commentController = new CommentController();
                        $commentController->addComment($projectId, $userId, $content);

                        header('Location: /main');
                        exit;
                    }

                    // Suppression de commentaire
                    if (isset($_POST['delete_comment']) && !empty($_POST['delete_comment'])) {
                        $commentId = intval($_POST['delete_comment']);
                        $userId = $_SESSION['user_id'];

                        $commentController = new CommentController();
                        $commentController->deleteComment($commentId, $userId);

                        header('Location: /main');
                        exit;
                    }

                    // Gestion des likes
                    if (isset($_POST['like_post']) && !empty($_POST['like_post'])) {
                        $projectId = intval($_POST['like_post']);
                        $userId = $_SESSION['user_id'];

                        $likeController = new LikeController();

                        if (LikeRepository::hasLiked($projectId, $userId)) {
                            $likeController->removeLike($projectId, $userId);
                        } else {
                            $likeController->addLike($projectId, $userId);
                        }

                        header('Location: /main');
                        exit;
                    }
                } catch (Exception $e) {
                    $_SESSION['error'] = "Erreur lors de l'exécution : " . $e->getMessage();
                    header('Location: /main');
                    exit;
                }
            }

            require(__DIR__ . "/../../views/Main.php");
        } else {
            header('Location: /register');
        }
    }
}
?>
