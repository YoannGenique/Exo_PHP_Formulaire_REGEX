<?php
    // try and catch pour la connexion bdd
    try{
        // Connexion base de donnée
        $pdo = new PDO('mysql:host=localhost;dbname=formulaire', 'root','');
    
    }catch (PDOException $e){
        echo 'Erreur : '. $e->getMessage();
        die();
    }
    // Si une valeur est envoyé et n'est pas vide
    if(isset($_POST) && isset($_FILES) && !empty($_POST) && !empty($_FILES)){

            // On nettoie les données envoyées
            // Supprime les balises HTML et PHP d'une chaîne
            $user_name = strip_tags($_POST['user_name']);
            $user_lastname = strip_tags($_POST['user_lastname']);
            $user_mail = strip_tags($_POST['user_mail']);
            $user_avatar = ($_FILES['user_avatar']);
            // Cripte le mdp en sha1
            $user_pass = sha1(strip_tags($_POST['user_pass']));

            // definis le valeur à maxsize(poid), ...
            define('MAX_SIZE', 600000);
            define('WIDTH_MAX', 1000);
            define('HEIGHT_MAX', 1000);

            // IMG 
            // nom de l'img
            $file_name = $_FILES['user_avatar']['name'];
            // on recupère le type de la photo(jpg,png...)
            $file_extension = strrchr($file_name,".");
            // img dossier temp
            $file_tmp_name = $_FILES['user_avatar']['tmp_name'];
            // Chemin du dossier de sav
            $file_dest= "img/$user_name.".$file_name;
            // extension de photo autorisée
            $extension_autorise = array('.jpeg','.jpg','.png','.gif','.webp');
            // Fin IMG

            // Regex
            // Rentre les valeurs de regex dans une var qui sera use plus tard 
            $regname = "/^[a-zA-Z-' ]*$/";
            // Fin Regex

            // Si la valeur rentrer par l'user ne contient que des Lettre en Maj ou Min de A-Z ON PASSE AU AUTRE VERIF
            if(preg_match($regname, $user_name)){

                if(preg_match($regname, $user_lastname)){
                    // Se renseigner sur les filter var et surtt sur FILTER_VALIDATE_EMAIL
                    if (filter_var($user_mail, FILTER_VALIDATE_EMAIL)){
                        // Import Img 
                        if (in_array($file_extension, $extension_autorise)){

                            if((filesize($_FILES['user_avatar']['tmp_name']) <= MAX_SIZE)){
                
                                if(move_uploaded_file($file_tmp_name, $file_dest)){
                
                                    //après verification du nom prenom mail on execute la requete
                                    $result=$pdo->prepare("INSERT INTO user(user_name, user_lastname, user_mail, user_avatar, user_pass) VALUES (?,?,?,?,?)");
                                    $result->execute(array($user_name, $user_lastname, $user_mail, $file_dest, $user_pass));

                                    echo "User enregistrer";
                                    // On fait la redirection
                                    header('Location:profil.php');
                
                                }else{
                                    echo "Une erreur lors de l'envoi du fichier";
                                }
                            }else{
                                echo "Image Trop Lourd";
                            }
                        }else{
                            echo "Extensions non autorisée, extension autorisée (jpeg, jpg, png, gif, webp)";
                        }

                    }else{
                        echo "Email Invalid";
                    }
                }else{
                    echo "Veuillez écrire votre Nom de Famille sans caractère spéciaux";
                }
            }else{
                echo "Veuillez écrire votre Prénom sans caractère spéciaux";
            }
    }
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
                <form method="POST" enctype="multipart/form-data">
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
                        <input name="user_mail" type="text" class="form-control" id="exampleInputPassword1">
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