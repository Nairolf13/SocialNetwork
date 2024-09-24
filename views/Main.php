<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" href="asset/imgs/social.png" type="icon main">
    <title>Reseau Social</title>
</head>

<body>
    <header>
        <h1>Bonjour <?php echo htmlspecialchars($username); ?></h1>
        <nav class="buttonHearder">
            <ul>
                <li><button id="btn-profile">Profil</button></li>
                <li><button id="btn-add-project">Ajouter un post</button></li>
                <li>
                    <a id="btn-deconnexion" href="/logout">Déconnexion</a>
                </li>
            </ul>
        </nav>
    </header>
    <main class="project_main">
        <div class="container_project">
            <h2>Mes Posts</h2>
            <ul id="project">
                <?php if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])): ?>
                    <?php
                    $currentUserId = $_SESSION['user_id'];
                    $userProjects = array_filter($projects, function ($project) use ($currentUserId) {
                        return $project['user_id'] == $currentUserId;
                    });
                    ?>
                    <?php if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id']) && (!empty($userProjects))): ?>
                        <?php foreach ($userProjects as $project): ?>
                            <li class="project-title"
                                data-project-id="<?php echo htmlspecialchars($project['id']); ?>"
                                data-project-title="<?php echo htmlspecialchars($project['title']); ?>"
                                data-project-description="<?php echo htmlspecialchars($project['description']); ?>">
                                <p>Posté par : <?php echo htmlspecialchars($project['username']); ?></p>
                                <h3><?php echo htmlspecialchars($project['title']); ?></h3>
                                <p><?php echo htmlspecialchars($project['description']); ?></p>
                                <p>Posté par : <?php echo htmlspecialchars($project['username']); ?></p>
                                <div class="button-container">
                                    <button class="btn-update-project">Modifier</button>
                                    <form action="/post" method="POST">
                                        <input type="hidden" name="delete_post" value="<?php echo htmlspecialchars($project['id']); ?>">
                                        <button type="submit" class="btn-remove-project">Supprimer</button>
                                    </form>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li>Aucun post à afficher .</li>
                    <?php endif; ?>
                <?php else: ?>
                    <li>Vous devez vous connecter pour voir les post.</li>
                <?php endif; ?>
            </ul>
        </div>
        <div class="main-content">
            <div class="allPost">
                <?php if (!empty($projects)): ?>
                    <?php foreach ($projects as $project): ?>
                        <li class="displayProjects">
                            <h3><?php echo htmlspecialchars($project['title']); ?></h3>
                            <p><?php echo htmlspecialchars($project['description']); ?></p>
                            <?php if (!empty($project['image'])): ?>
                                <img src="/storage/imgsUploade/<?php echo htmlspecialchars($project['image']); ?>" alt="<?php echo htmlspecialchars($project['title']); ?>" style="max-width: 100%;">
                            <?php endif; ?>
                            <div class="button-container">
                                <form action="/like" method="POST">
                                    <input type="hidden" name="like_post" value="<?php echo htmlspecialchars($project['id']); ?>">
                                    <button type="submit" class="btn-like">
                                        <span class="buttonPost"><?php echo htmlspecialchars($project['likes_count']); ?><img class="logoPost" src="asset/imgs/like.png" alt=""></span>
                                    </button>
                                </form>
                                <form action="/main" method="POST">
                                    <input type="hidden" name="post_comment_project_id" value="<?php echo htmlspecialchars($project['id']); ?>">
                                    <button type="submit" name="view_comments" class="btn-comment">
                                        <span class="buttonPost"><?php echo htmlspecialchars($project['comments_count']); ?><img class="logoPost" src="asset/imgs/commente.png" alt=""></span>
                                    </button>
                                </form>
                            </div>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <div id="commentModal" class="modal" style="display: <?php echo isset($selectedProjectId) ? 'block' : 'none'; ?>;">
                <div class="modal-content">
                    <span class="close">x</span>
                    <?php if ($selectedProjectId): ?>
                        <?php foreach ($projects as $project): ?>
                            <?php if ($project['id'] == $selectedProjectId): ?>
                                <div class="project">
                                    <div id="commentsContainer" class="comments-section">
                                        <?php if (!empty($selectedComments)): ?>
                                            <?php foreach ($selectedComments as $comment): ?>
                                                <div class="comment">
                                                    <form action="/comment" method="POST">
                                                        <input type="hidden" name="delete_comment" value="<?php echo htmlspecialchars($comment['id']); ?>">
                                                        <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($_SESSION['user_id']); ?>">
                                                        <button id="buttonRemoveCom" type="submit" class="close">x</button>
                                                    </form>
                                                    <p><strong><?php echo htmlspecialchars($comment['user_name']); ?> :</strong></p>
                                                    <p><?php echo htmlspecialchars($comment['content']); ?></p>
                                                    <hr>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <p>Aucun commentaire pour le moment.</p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Sélectionnez un projet pour voir ses commentaires.</p>
                    <?php endif; ?>
                    <form id="commentForm" action="/comment" method="POST">
                        <input type="hidden" name="project_id" value="<?php echo htmlspecialchars($selectedProjectId); ?>">
                        <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
                        <textarea name="content" placeholder="Écrivez votre commentaire..."></textarea>
                        <button id="buttonComment" type="submit">Envoyer</button>
                    </form>
                </div>
            </div>
        </div>
        <div id="add-project-form" class="formulaire_project hidden">
            <form action="/post" method="POST" enctype="multipart/form-data">
                <label for="title">Titre :</label>
                <input type="text" id="title" name="title" required><br>

                <label for="description">Description :</label>
                <textarea id="description" name="description" required></textarea><br>

                <label for="image">Image :</label>
                <input type="file" id="image" name="image" accept="image/jpeg, image/png, image/gif"><br>

                <button type="submit">Ajouter un post</button>
            </form>
        </div>
        <div id="update-project-form" class="formulaire_project hidden">
            <form id="update-form" action="/post" method="POST" enctype="multipart/form-data">
                <input type="hidden" id="update-project-id" name="id">
                <label for="update-title">Titre :</label>
                <input type="text" id="update-title" name="title" value="" required><br>

                <label for="update-description">Description :</label>
                <textarea id="update-description" name="description" value="" required></textarea><br>

                <label for="image">Image :</label>
                <input type="file" id="image" name="image" accept="image/jpeg, image/png, image/gif"><br>

                <input type="hidden" name="update_post" value="1">
                <button type="submit">Mettre à jour le Projet</button><br>
            </form>
            <button type="button" id="close-update-project-form">Annuler</button>
        </div>
        </div>
        <div id="profile-modal" class="modal hidden">
            <div class="modal-content">
                <h2>Informations</h2>
                <form action="/update" method="POST">
                    <input type="hidden" name="getUserById" value="<?php echo htmlspecialchars($userid); ?>">

                    <label for="username">Nom d'utilisateur :</label>
                    <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>">

                    <label for="email">Email :</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($useremail); ?>">

                    <button type="submit" name="action" value="update">Mettre à jour</button><br>

                    <button type="button" id="close-profile-modal">Annuler</button><br>
                </form>
                <form action="/update" method="post">
                    <label for="old_password">Ancien mot de passe :</label>
                    <input type="password" id="old_password" name="old_password">

                    <label for="new_password">Nouveau mot de passe :</label>
                    <input type="password" id="new_password" name="new_password">

                    <label for="confirm_password">Confirmer le nouveau mot de passe :</label>
                    <input type="password" id="confirm_password" name="confirm_password"><br>

                    <button type="submit" name="action" value="updatemdp">Mettre à jour</button><br>
                </form>
                <form action="/register" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer votre compte ? Cette action est irréversible.');">
                    <input type="hidden" name="action" value="delete">
                    <button id="removeAccount" type="submit" name="deleteUser" value="<?php echo htmlspecialchars($userid); ?>">Supprimer mon compte</button>
                </form>
            </div>
        </div>
        <?php if (!empty($error)): ?>
            <div id="errorModal" class="modal-error">
                <div class="modal-content-error">
                    <span class="close">&times;</span>
                    <p id="errorMessage"><?php echo htmlspecialchars($error); ?></p>
                </div>
            </div>
        <?php endif; ?>
    </main>
    <script src="../../js/script.js"></script>
</body>

</html>