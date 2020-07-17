<?php
session_start();
    // JUSTE POUR AFFICHER LES ERREURS 
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    

    $db = new PDO("mysql:host=localhost;dbname=createUser","root","root");



    $select = $db->query("SELECT * FROM users");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN PANEL</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.1/css/all.css" integrity="sha384-xxzQGERXS00kBmZW/6qxqJPyxW3UR0BPsL4c8ILaIWXva5kFi7TxkIIaMiKtqV1Q" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/admin.css">
    <link href="https://fonts.googleapis.com/css2?family=Fredoka+One&display=swap" rel="stylesheet">
</head>
<body>

    <div class="container">
        <h1>ADMIN PAGE</h1>
        <div class="database">
            <?php 
                while($resultSelect = $select->fetch()){
                    echo "<div class='user'>";
                    echo "<p class='userID'>".$resultSelect['id']."</p>";
                    echo "<p class='userUsername'>".$resultSelect['username']."</p>";
                    echo "<p class='userMail'>".$resultSelect['mail']."</p>";
                    echo "</div>";
                }



                
            ?>
        </div>
    </div>
</body>
</html>