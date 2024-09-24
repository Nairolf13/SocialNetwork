<?php
session_start();
require_once ('../core/Router.php');
require_once ('../src/models/Db.php');
require_once ('../src/controllers/Controller.php');
require_once ('../src/models/repository/UserRepository.php');
require_once ('../src/models/repository/PostRepository.php');
require_once ('../src/models/repository/LikeRepository.php');
require_once ('../src/models/repository/CommentRepository.php');
require_once ('../src/controllers/PostController.php');
require_once ('../src/controllers/LikeController.php');
require_once ('../src/controllers/CommentController.php');
require_once ('../src/models/User.php');
require_once ('../src/models/Like.php');
require_once ('../src/models/Comment.php');
require_once ('../src/models/Post.php');
require_once ('../src/controllers/MainController.php');
require_once ('../src/controllers/LogoutController.php');
require_once ('../src/controllers/RegisterController.php');
require_once ('../src/controllers/LoginController.php');
require_once ('../src/controllers/UpdateController.php');
// require_once ('../src/controllers/ImageController.php');

try{
    $app = new router();
    $app->start();
}catch (PDOException $e){
    exit($e->getMessage());
}

?>