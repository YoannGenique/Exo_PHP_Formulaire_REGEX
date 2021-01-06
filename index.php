<?php
    require_once('inscription_user.php');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>formulaire</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body class="body">
    <header>
    </header>
    <main>
        <section>
            <div class="form">
                <div class="titre">
                    <h1>Inscription</h1>               
                </div>
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="user_name" class="form-label">Nom Utilisateur</label>
                        <input name="user_name" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="user_lastname" class="form-label">Nom de Famille Utilisateur</label>
                        <input name="user_lastname" type="text" class="form-control" id="exampleInputPassword1">
                    </div>
                    <div class="mb-3">
                        <label for="user_mail" class="form-label">Email Utilisateur</label>
                        <input name="user_mail" type="email" class="form-control" id="exampleInputPassword1">
                    </div>
                    <div class="mb-3">
                        <label for="user_avatar" class="form-label">Photo de Profil Utilisateur</label>
                        <input name="user_avatar" type="file" class="form-control" id="exampleInputPassword1">
                    </div>
                    <div class="mb-3">
                        <label for="user_pass" class="form-label">Mot de Passe Utilisateur</label>
                        <input name="user_pass" type="password" class="form-control" id="exampleInputPassword1">
                    </div>
                    <button type="submit" class="btn btn-primary btn_me">Inscription</button>
                </form>
            </div>
        </section>
    </main>
</body>
</html>