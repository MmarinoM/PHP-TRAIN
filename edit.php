<?php 
    session_start();
    // JUSTE POUR AFFICHER LES ERREURS 
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    //VARIABLE POUR LE MESSAGE D ERREUR
    $alert = null;
    $alert2 = null;
    $alert3 = null;

    $db = new PDO("mysql:host=localhost;dbname=createUser","root","root");
    if(isset($_GET['id']) && $_GET['id']>0){
        $getid = intval($_GET['id']);
        $displayUser = $db->prepare("SELECT * FROM users WHERE id = ?");
        $displayUser->execute(array($getid));
        $userInfo = $displayUser->fetch();
    
    }

    if(isset($_POST['setNewInfo'])){
        $newUsername = htmlspecialchars($_POST['newUN']);
        $newEmail = htmlspecialchars($_POST['newMail']);
        $newPWD = sha1($_POST['newPWD']);
        $currentPWD = sha1($_POST['currentPWD']);
        $ConfirmNewPWD = sha1($_POST['confirmNewPWD']);
        $newEmailConfirm = htmlspecialchars($_POST['newMailConfirm']);

        $newUsernameLength = strlen($newUsername);


        // VERIF NOUVEAU USERNAME
        if(!empty($newUsername)){
            if($newUsername == $userInfo['username']){
                $alert = "Tu utilise déjà ce username gogol ...";
            }
            else{
                // VERIF SI PSEUDO DISPO
                $verifNewUsername = $db->prepare("SELECT * FROM users WHERE username = ?");
                $verifNewUsername->execute(array($newUsername));
                $newUsernameExist = $verifNewUsername->rowCount();
                if($newUsernameExist == 0){
                    if($newUsernameLength < 255){
                        $insertNewUsername = $db->prepare("UPDATE users SET username = ? WHERE id = ?");
                        $insertNewUsername -> execute(array($newUsername,$_SESSION['id']));
                    }
                    else{
                        $alert = "Pseudo trop long t'abuses un peu la ...";
                    }
                }
                else{
                    $alert = "ce username est déjà pris cognooo";
                }
            }
        }
        else{
            
        }

        // VERIF NOUVEL EMAIL 
        if(!empty($newEmail)){
            if($newEmail == $newEmailConfirm){
                if($newEmail == $userInfo['mail']){
                    $alert2 = "Tu utilise déjà cet email bébé";
                }
                else{
                    if(filter_var($newEmail,FILTER_VALIDATE_EMAIL)){
                        $verifNewMail = $db->prepare("SELECT * FROM users WHERE mail = ?");
                        $verifNewMail->execute(array($newEmail));
                        $verifNewMailExist = $verifNewMail->rowCount();
                        if ($verifNewMailExist == 0){
                            $insertNewMail = $db->prepare("UPDATE users SET mail = ? WHERE id = ?");
                            $insertNewMail->execute(array($newEmail,$_SESSION['id']));
                        }
                        else{
                            $alert2 = "Adresse Email déjà utilisée";
                        }
                    }
                    else{
                        $alert2 = "email pas valide essaye pas de me la faire à l'envers";
                    }
                }
            }
            else{
                $alert2 = "l'email et l'email de confirmation ne sont pas les même fiston";
            }
                
            
                
        }

        // VERIF PASSWORD
        if($currentPWD == $_SESSION['password']){
            if($newPWD == $ConfirmNewPWD){
                $insertNewPWD = $db->prepare("UPDATE users SET password = ? WHERE id = ?");
                $insertNewPWD->execute(array($newPWD,$_SESSION['id']));
            }
            else{
                $alert3 = "les 2 nouveaux password ne correspondent pas ...";
            }
        }
        else{
            $alert3 = "le current password n'est pas le bon";
        }
        
        header("location: edit.php?id=".$_SESSION['id']);
            exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EDIT YOUR PROFILE</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.1/css/all.css" integrity="sha384-xxzQGERXS00kBmZW/6qxqJPyxW3UR0BPsL4c8ILaIWXva5kFi7TxkIIaMiKtqV1Q" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Fredoka+One&display=swap" rel="stylesheet">
</head>
<body>
    <?php include 'header.php';?>
    <?php 
        if(isset($_SESSION['id'])){
            if($_SESSION['id'] == $userInfo['id']){
    ?>
                <div class="container">
                <div class="currentValue">
                    <p class="currentTitle">Current Username </p>
                    <p class="currentInfo"><?php echo $userInfo['username']?></p>
                    <p class="currentTitle">Current E-mail adress </p>
                    <p class="currentInfo"><?php echo $userInfo['mail']?></p>
                </div>
                <p id="alert"><?php 
                if(isset($alert)){
                    echo $alert;
                }
                ?>
                </p>
                <p id="alert"><?php 
                if(isset($alert2)){
                    echo $alert2;
                }
                ?>
                </p>
                </p>
                <p id="alert"><?php 
                if(isset($alert3)){
                    echo $alert3;
                }
                ?>
                </p>

                <form method="post">
                    <label for="newUN">New Username</label>
                    <input type="text" name="newUN" id="newUN" placeholder="Your new username here">
                    <br><br>

                    <label for="newMail">New E-Mail adress</label>
                    <input type="email" name="newMail" id="newMail" placeholder="Your new E-Mail adress here">
                    <label for="newMailConfirm">Confirm new E-Mail adress</label>
                    <input type="email" name="newMailConfirm" id="newMailConfirm" placeholder="Confirm new E-Mail here">
                    <br><br>
                    
                    <label for="currentPWD">Current password</label>
                    <input type="password" name="currentPWD" id="currentPWD" placeholder="Your current password here">

                    <label for="newPWD">New password</label>
                    <input type="password" name="newPWD" id="newPWD" placeholder="Your new password here">

                    <label for="confirmNewPWD">Confirm new password</label>
                    <input type="password" name="confirmNewPWD" id="confirmNewPWD" placeholder="Confirm the new password here">
                    
                    <input type="submit" name="setNewInfo" id="submitEdit" value="SET CHANGES">
                
                </form>
                <br><br><br>
                </div>
        <?php
            }
        else{
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