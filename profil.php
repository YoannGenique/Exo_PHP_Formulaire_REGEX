<?php
    try{
        // Connexion base de donnée
        $db = new PDO('mysql:host=localhost;dbname=formulaire', 'root','');
        $db->exec('SET NAMES "UTF8"');
    
    }catch (PDOException $e){
        echo 'Erreur : '. $e->getMessage();
        die();
    }

    $sql = 'SELECT * FROM `user`';
    // On prepare la requete
    $query = $db->prepare($sql);
    // on execute la requete
    $query->execute();
    // on stock le result dans un tableau assoc
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
    // Ferme la base de donnée, require stop le script si y'a une erreur comparer à include et once sert à la vérification de si le code à déjà été excécuter 
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
    <a href="index.php"><img style="margin: 25px;" src="deco_ico.png" alt="" width="50"></a>
    </header>
    <main>
        <section>
            <div class="cd">
                <?php foreach($result as $user): extract($user) ?>
                <div class="card gr" style="width: 18rem;">
                    <img src="<?=$user_avatar?>" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title"><?=$user_name." " .$user_lastname?></h5>
                        <p class="card-text"><?=$user_mail?></p>
                    </div>
                </div>
                <?php endforeach ?>
            </div>
        </section>
    </main>
</body>
</html>