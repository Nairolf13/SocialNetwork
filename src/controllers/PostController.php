<?php

class PostController extends Controller
{
    public function index()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                
                if (isset($_POST['delete_post'])) {
                    $project_id = intval($_POST['delete_post']);
                    PostRepository::deletePost($project_id);
                    header("Location: /");
                    exit;
                }

                if (isset($_POST['update_post'])) {
                    $project_id = intval($_POST['id']); 
                    $title = htmlspecialchars($_POST['title']);
                    $description = htmlspecialchars($_POST['description']);
                
                    $imagePath = null;
                    if (isset($_FILES['image']['tmp_name']) && !empty($_FILES['image']['tmp_name'])) {
                        $uploadDir = __DIR__ . '/../../public/storage/imgsUploade/';
                        $imagePath = basename($_FILES['image']['name']);
                        move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $imagePath);
                    }
             
                    $postData = new Post($title, $description, $imagePath, $project_id, $_SESSION['user_id']);
                    PostRepository::updateProjects($postData);
                
                    header("Location: /");
                    exit;
                }
                
                $title = htmlspecialchars($_POST['title']);
                $description = htmlspecialchars($_POST['description']);
                $user_id = $_SESSION['user_id'];

                $imagePath = null;
                if (!empty($_FILES['image']['tmp_name'])) {
                    $uploadDir = __DIR__ . '/../../public/storage/imgsUploade/';
                    $imagePath = basename($_FILES['image']['name']);
                    move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $imagePath);
                }
                
                $post = new Post($title, $description, $imagePath, null, $user_id);
                PostRepository::CreatePost($post);

                header("Location: /");
                exit;

            } catch (Exception $e) {
                $_SESSION['error'] = "Erreur lors de l'exécution : " . $e->getMessage();
                header("Location: /");
                exit;
            }
        }
    }
}
?>
