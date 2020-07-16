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
    <div class="container">
        <div class="currentValue">
            <p>Current Username :</p>
            <p>test</p>
            <p>Current E-mail adress :</p>
            <p>test@test.be</p>
        </div>
        <form method="post">
            <label for="newUN">New Username</label>
            <input type="text" name="newUN" id="newUN" placeholder="Your new username here">
            <label for="newMail">New E-Mail adress</label>
            <input type="email" name="newMail" id="newMail" placeholder="Your new E-Mail adress here">
            <input type="submit" name="setNewInfo" id="submitEdit" value="SET CHANGES">
        </form>
    </div>
</body>
</html>