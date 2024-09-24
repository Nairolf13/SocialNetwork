<?php

// class ImageController extends Controller
// {
//     public function index()
//     {
//         try {
//             if (isset($_GET['id'])) {
//                 $id = intval($_GET['id']); 
//                 $imageModel = new PostRepository();
//                 $image = $imageModel->getImageById($id);
                
//                 if ($image && $image['image']) {
//                     $finfo = new finfo(FILEINFO_MIME_TYPE);
//                     $mime_type = $finfo->buffer($image['image']);

//                     header("Content-Type: " . $mime_type);
//                     header("Content-Length: " . strlen($image['image']));
//                     echo $image['image'];
//                     exit;
//                 } else {
//                     http_response_code(404);
//                     echo "Image non trouvée";
//                 }
//             } else {
//                 http_response_code(400);
//                 echo "ID de l'image non spécifié";
//             }
//         } catch (Exception $e) {
//             error_log("Erreur dans ImageController : " . $e->getMessage());
//             http_response_code(500);
//             echo "Erreur interne du serveur";
//         }
//     }
// }
