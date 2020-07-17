<?php 
session_start();
// JUSTE POUR AFFICHER LES ERREURS 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$db = new PDO("mysql:host=localhost;dbname=createUser","root","root");
$error = null;


if(isset($_POST['submitLogin'])){
    $usernameConnect = htmlspecialchars($_POST['usernameLogin']);
    $pwdConnect = sha1($_POST['pwdLogin']);

    if(!empty($_POST['usernameLogin']) && !empty($_POST['pwdLogin'])){
        $checkBDuser = $db->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
        $checkBDuser->execute(array($usernameConnect, $pwdConnect));
        $checkExist = $checkBDuser->rowCount();
        if($checkExist == 1){
            $userInfo = $checkBDuser->fetch();
            $_SESSION['username'] = $userInfo['username'];
            $_SESSION['id'] = $userInfo['id'];
            $_SESSION['mail'] = $userInfo['mail'];
            $_SESSION['password'] = $userInfo['password'];
            if($_SESSION['username'] == 'admin'){
                header("location: admin.php");
                exit();
            }else{
                header("location: profil.php?id=".$_SESSION['id']);
            exit();
            }
            
        }
        else{
            $error = "sorry frero mais ce compte n'existe pas";
        }
    }
    else{
        $error = "tous les champs ne sont pas remplis chaton";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Fredoka+One&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container containFlex">
        <h1>LOGIN</h1>
        <form method="POST" id="loginForm">
            
            <input type="text" name="usernameLogin" placeholder="Your username">
            <input type="password" name="pwdLogin" placeholder="Your password">
            <input type="submit" name="submitLogin" value="login" id="loginSubmit">
        </form>
        <p id="alert"><?php 
        if(isset($error)){
            echo $error;
        }
        ?>
        </p>
        <h2 class="or">OR</h2>
        <a href="register.php" class="register" >Create an account</a>
    </div>
</body>
</html>