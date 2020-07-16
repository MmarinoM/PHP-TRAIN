<?php
    // JUSTE POUR AFFICHER LES ERREURS 
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);



// DECLARATION DE VARIABLE POUR LE TEXTE DE CONFIRMATION
    $alert = null;
    $good = null;


    $db = new PDO("mysql:host=localhost;dbname=createUser","root","root");


    if(isset($_POST['submit'])){

        // CONVERT DES INFO DU FORM
        $username = htmlspecialchars($_POST['username']);
        $mail = htmlspecialchars($_POST['mail']);
        $mail2 = htmlspecialchars($_POST['mail2']);
        // se renseigner BCRYPT
        $pwd = sha1($_POST['pwd']);
        $pwd2 = sha1($_POST['pwd2']);
        $usernameLength = strlen($username);

        // VERIF QUE TOUT EST REMPLIS 
        if(!empty($_POST['username']) AND !empty($_POST['mail']) AND !empty($_POST['pwd'])){
            if($usernameLength <= 255){
                // VERIF SI PSEUDO DISPO
                $verifUsername = $db->prepare("SELECT * FROM users WHERE username = ?");
                $verifUsername->execute(array($username));
                $usernameExist = $verifUsername->rowCount();
                if($usernameExist == 0){
                    if($mail == $mail2){
                        if(filter_var($mail,FILTER_VALIDATE_EMAIL)){
                            // VERIF SI MAIL DEJA UTILISEE
                            $verifMail = $db->prepare("SELECT * FROM users WHERE mail = ?");
                            $verifMail->execute(array($mail));
                            $mailExist = $verifMail->rowCount();
                            if($mailExist == 0){
                                if($pwd === $pwd2){
                                    $good = "nickel cousin";
                                    $addDB = $db->prepare("INSERT INTO users (username, mail, password) VALUES ( :username, :mail, :pwd)"); 
                                    $addDB->bindParam('username',$username);
                                    $addDB->bindParam('mail', $mail);
                                    $addDB->bindParam('pwd', $pwd);
                                    $addDB->execute();
                                    header('location: good.php');
                                    exit();
                                }
                                else{
                                    $alert = "les 2 password ne correspondent pas";
                                }
                            }
                            else{
                                $alert = "adresse mail déjà utilisée frere";
                            }    
                                
                        }
                        else{
                            $alert = "essaye pas de me la faire a l'envers zeubi";
                        }
                            
                        
                    }
                    else{
                        $alert = "les 2 mails ne correspondent pas";
                    }
                }
                else{
                    $alert = "username déjà utliser , soit un peu creatif bon sang ";
                }

              
            }
            else{
                $alert = "USERNAME TROP LOOOOOONG , 255 caractère max ! ";
            }
        }else{
            $alert = "t'as pas tout remplis frerooooo";
        }

    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FORM</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Fredoka+One&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Create an account</h1>
        <form method="POST">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" placeholder="Your username here" value="<?php if(isset($username)){ echo $username; } ?>">
            <label for="mail">Email</label>
            <input type="email" name="mail" id="mail" placeholder="Your Email here" value="<?php if(isset($mail)){ echo $mail; } ?>">
            <label for="mail2">Confirm email</label>
            <input type="email" name="mail2" id="mail2" placeholder="Confirm your Email here" value="<?php if(isset($mail2)){ echo $mail2; } ?>">
            <label for="pwd">Password</label>
            <input type="password" name="pwd" id="pwd" placeholder="Your password here" value="">
            <label for="pwd2">Confirm password</label>
            <input type="password" name="pwd2" id="pwd2" placeholder="Confirm your password here" value="">
            <input type="submit" name="submit" id="submit" value="CREATE">


        </form>
        <p id="alert"><?php 
        if(isset($alert)){
            echo $alert;
        }
        ?>
        </p>
        <p id="good">
            <?php 
            if(isset($good)){
                echo $good;
            }
            ?>
        </p>
    </div>
</body>
</html>