<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once("../config/mysql-config.php");
include_once("../PHP/mc-api.php");

if (!isset($_GET['link'])) {
    die("Die Angegebene URL enthält keinen Registrierungslink");
} else {
    $link = $_GET['link'];
    $uuid = "";

    $register_statement = $pdo->prepare("SELECT * FROM Freebuild_RegisterLinks WHERE Link = :link");
    $register_execute = $register_statement->execute(array('link' => $link));
    $register_result = $register_statement->fetch();

    if (!empty($register_result)) {
        $uuid = $register_result['UUID'];
    }

    $nowDate = date("r");
    $expireDate = date("r", $register_result['Expire'] / 1000);

    $now = strtotime($nowDate);
    $expire = strtotime($expireDate);

    $expired = ($now >= $expire ? true : false);
}

?>

<!doctype html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Freebuild - Registrieren</title>

    <link rel="stylesheet" href="../style/login.css">
</head>
<body>

<form method="post" action="register.php">
    <center><h1>Registrieren</h1></center>

    <input type="hidden" value="<?php echo($link); ?>" name="link">

    <input type="text" id="UUID" name="UUID" readonly value="<?php echo(uuid_to_username($uuid)); ?>"><br>
    <input type="email" id="Mail" name="Mail" placeholder="E-Mail" autocomplete="off"><br>
    <input type="password" id="Passwort" name="Passwort" required placeholder="Passwort" autocomplete="off"><br>


    <input type="submit" value="Registrieren" name="send">
</form>

</body>
</html>
