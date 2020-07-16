<?php 
session_start();
// JUSTE POUR AFFICHER LES ERREURS 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$db = new PDO("mysql:host=localhost;dbname=createUser","root","root");

if(isset($_GET['id']) && $_GET['id']>0){
    $getid = intval($_GET['id']);
    $displayUser = $db->prepare("SELECT * FROM users WHERE id = ?");
    $displayUser->execute(array($getid));
    $userInfo = $displayUser->fetch();

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PROFIL</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.1/css/all.css" integrity="sha384-xxzQGERXS00kBmZW/6qxqJPyxW3UR0BPsL4c8ILaIWXva5kFi7TxkIIaMiKtqV1Q" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Fredoka+One&display=swap" rel="stylesheet">
</head>
<body>

    <?php include 'header.php';?>

    <!-- <div class="container">
        <h1>Bonjour <?php echo $userInfo['username']; ?></h1>
        <img src="https://media.giphy.com/media/UtPaT0rqpQ8O3EEHyX/giphy.gif" alt="" class="gif">
    </div>
 -->



    <?php
        if(isset($_SESSION['id'])){
            if($_SESSION['id'] == $userInfo['id']){
        
            
        ?>
            <div class="container">
            <h1>Bonjour <?php echo $userInfo['username']; ?></h1>
            <img src="https://media.giphy.com/media/UtPaT0rqpQ8O3EEHyX/giphy.gif" alt="" class="gif">
    </div>
        
        <?php
        
            }else{
                ?>
                <div class="container">

                <h1>YOU RE NOT SUPPOSED TO BE HERE</h1>
                    <img src="https://media.giphy.com/media/QyhRSOmynFmYpMHB3y/giphy.gif" alt="" class="gif">
                </div>
                    
                <?php

            }
        }
        ?>
</body>
</html>