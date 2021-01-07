<?php
    try{
        // Connexion base de donnée
        $db = new PDO('mysql:host=localhost;dbname=formulaire', 'root','');
        $db->exec('SET NAMES "UTF8"');
    
    }catch (PDOException $e){
        echo 'Erreur : '. $e->getMessage();
        die();
    }
    if($_POST && $_FILES){

        //Vérifie Si les champs ne sont pas vide
        if(isset($_POST['user_name']) && !empty($_POST['user_name'])
        && isset($_POST['user_lastname']) && !empty($_POST['user_lastname'])
        && isset($_POST['user_mail']) && !empty($_POST['user_mail'])
        && isset($_FILES['user_avatar']) && !empty($_FILES['user_avatar'])
        && isset($_POST['user_pass']) && !empty($_POST['user_pass'])){

            // On nettoie les données envoyées
            // Supprime les balises HTML et PHP d'une chaîne
            $user_name = strip_tags($_POST['user_name']);
            $user_lastname = strip_tags($_POST['user_lastname']);
            $user_mail = strip_tags($_POST['user_mail']);
            $user_avatar = strip_tags($_FILES['user_avatar']);
            $user_pass = sha1(strip_tags($_POST['user_pass']));
    
            $p = "/^[a-zA-Z-' ]*$/";

            // if(preg_match($p, $_POST['user_name'])){
            //     $pre="correct";
            // }else{
            //     $pre="incorrect";
            // }

            // if(preg_match($p, $_POST['user_lastname'])){
            //     $las="correct";
            // }else{
            //     $las="incorrect";
            // }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $mailErr = "Invalid email";
            }

            define('MAX_SIZE', 600000);
            define('WIDTH_MAX', 1000);
            define('HEIGHT_MAX', 1000);
             
                $file_name = $_FILES['user_avatar']['name'];
            
                $file_extension = strrchr($file_name,".");
           
                $file_tmp_name = $_FILES['user_avatar']['tmp_name'];
                
                $file_dest= 'img/'.$file_name;
        
                $extension_autorise = array('.jpeg','.jpg','.png','.gif','.webp');
        
                if (in_array($file_extension, $extension_autorise)){

                    if((filesize($_FILES['user_avatar']['tmp_name']) <= MAX_SIZE)){
        
                        if(move_uploaded_file($file_tmp_name, $file_dest)){
        
                            echo 'Fichier envoyé';
        
                        }else{
                            echo"Une erreur lors de l'envoi du fichier";
                        }
                    }else{
                        echo 'Trop Lourd';
                    }
                }else{
                    echo 'Extensions non autorisée';
                }
                   
                // Insert dans la Table formulaire, les champs remplie correspondant à la ligne correspondant
                $sql = 'INSERT INTO `user` (`user_name`, `user_lastname`, `user_mail`, `user_avatar`, `user_pass`) VALUES (:user_name, :user_lastname, :user_mail, :file_dest, :user_pass)';
                // On prepare la requête
                $query = $db->prepare($sql);
                // excute tt les param rentrer
                $query->execute();
                // On fait la redirection vers la dashboard ou sera affiché le message 
                header('Location:profil.php');
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
                        <?php 
                        $p = "/^[a-zA-Z-' ]*$/";

                        if(isset($_POST['user_name'])){
                            if(preg_match($p, $_POST['user_name'])){
                                $pre="correct";
                            }else{
                                header('index.php');
                                $pre="incorrect";
                            }
                        }         
                        ?>
                    </div>
                    <div class="mb-3">
                        <label for="user_lastname" class="form-label">Nom de Famille Utilisateur</label>
                        <input name="user_lastname" type="text" class="form-control" id="exampleInputPassword1">
                        <?php
                        if(isset($_POST['user_lastname'])){
                            if(preg_match($p, $_POST['user_lastname'])){
                                $las="correct";
                            }else{
                                header('index.php');
                                $las="incorrect";
                            }
                        }
                        ?>
                    </div>
                    <div class="mb-3">
                        <label for="user_mail" class="form-label">Email Utilisateur</label>
                        <input name="user_mail" type="email" class="form-control" id="exampleInputPassword1">
                        <?php
                        if(isset($_POST['user_mail'])){
                            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                                header('index.php');
                                $mailErr = "Invalid email";
                            }
                        }
                        ?>
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