<?php
try{
    // Connexion base de donnée
    $db = new PDO('mysql:host=localhost;dbname=formulaire', 'root','');
    $db->exec('SET NAMES "UTF8"');

}catch (PDOException $e){
    echo 'Erreur : '. $e->getMessage();
    die();
}

