<!doctype html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Freebuild - Login</title>

    <link rel="stylesheet" href="../style/login.css">
</head>
<body>

<form method="post" action="login.php">
    <center><h1>Einloggen</h1></center>

    <input type="hidden" value="<?php echo($link); ?>" name="link">

    <input type="text" id="Username" name="Username" placeholder="Minecraft Name" autocomplete="off" required><br>
    <input type="password" id="Passwort" name="Passwort" placeholder="Passwort" autocomplete="off" required><br>

    <input type="submit" value="Registrieren" name="send">
</form>

</body>
</html>