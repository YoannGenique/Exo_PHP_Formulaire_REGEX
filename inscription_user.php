<?php
    require_once('pdo.php');

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
            $user_avatar = ($_FILES['user_avatar']);
            $user_pass = sha1(strip_tags($_POST['user_pass']));


                //met dans la var le chemin ou je veux que le ticket soit save 
                $uploadchemin = "img/$user_name";
                // On insert dans la var $uploadfile le chemin plus nom du fichier envoyer dans la $_FILES
                $uploadfichier = $uploadchemin . basename($_FILES['user_avatar']['name']);
                // Si le fichier télécharger n'est pas déplacé à l'endroit indiqué alors il sera déplacé
                if (!move_uploaded_file($_FILES['user_avatar']['tmp_name'], $uploadfichier)){
                    $_SESSION['erreurimp'] = "Il y'a eu un problème avec l'importation de l'avatar";
                }
                // Insert dans la Table formulaire, les champs remplie correspondant à la ligne correspondant
                $sql = 'INSERT INTO `user` (`user_name`, `user_lastname`, `user_mail`, `user_avatar`, `user_pass`) VALUES (:user_name, :user_lastname, :user_mail, :user_avatar, :user_pass)';
                // On prepare la requête
                $query = $db->prepare($sql);
                // On param notre  requete query avec le param adéquat à chaque champ(associe une valeur à un param)(param varchar text)
                $query->bindValue(':user_name', $user_name, PDO::PARAM_STR);
                $query->bindValue(':user_lastname', $user_lastname, PDO::PARAM_STR);
                $query->bindValue(':user_mail', $user_mail, PDO::PARAM_STR);
                $query->bindValue(':user_avatar', $uploadfichier, PDO::PARAM_STR);
                $query->bindValue(':user_pass', $user_pass, PDO::PARAM_STR);
                // excute tt les param rentrer
                $query->execute();
                // On parametre le message si tout à fonctionner
                $_SESSION['message'] = "Success vous êtes inscrit avec succès";
                // On ferme la base de donnée,  require stop le script si y'a une erreur comparer à include et once sert à la vérification de si le code à déjà été excécuter 
                require_once('close.php');
                // On fait la redirection vers la dashboard ou sera affiché le message 
                header('Location:profil.php');
    
    }else{
        // On parametre le message d'erreur si les champs ne sont pas complet
        $_SESSION['erreur'] = "Il vous reste des champs à Remplir";
    } 
}
?>