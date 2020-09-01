<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once("../config/mysql-config.php");
include_once("../PHP/mc-api.php");

$link = $_REQUEST['link'];

$registerlink_statement = $pdo->prepare("SELECT * FROM Freebuild_RegisterLinks WHERE Link = :link");
$registerlink_execute = $registerlink_statement->execute(array('link' => $link));
$registerlink_result = $registerlink_statement->fetch();


$nowDate = date("r");
$expireDate = date("r", $registerlink_result['Expire'] / 1000);

$now = strtotime($nowDate);
$expire = strtotime($expireDate);

$expired = (string)($now >= $expire ? true : false);

if (isset($_REQUEST['send'])) {

    $UUID = username_to_uuid($_POST['UUID']);
    $mail = $_REQUEST['Mail'];

    if (!$expired) {
        // ERFOLG
        $hash_password = password_hash($_REQUEST['Passwort'], PASSWORD_DEFAULT);

        $registered_statement = $pdo->prepare("INSERT INTO `Freebuild_Logins`(`UUID`, `Passwort`, `Mail`) VALUES (:uuid,:password,:mail)");
        $registered_execute = $registered_statement->execute(array('uuid' => $UUID, 'password' => $hash_password, 'mail' => $mail));

        if ($registered_execute) {
            echo("<div class='info'><p>Du hast dich erfolgreich registriert. <a href='../login/index.php'>Logge dich ein.</a></p></div>");

            $registerlink_statement = $pdo->prepare("DELETE FROM Freebuild_RegisterLinks WHERE Link = :link");
            $registerlink_execute = $registerlink_statement->execute(array('link' => $link));
        } else {
            echo($registered_statement->errorCode());
        }
    } else {
        echo("<div class='info'><p>Dein Registrierungslink ist bereits abgelaufen, generiere dir auf dem Server einen neuen, indem zu /webpanel register eingibst.</p></div>");

        $registerlink_statement = $pdo->prepare("DELETE FROM Freebuild_RegisterLinks WHERE Link = :link");
        $registerlink_execute = $registerlink_statement->execute(array('link' => $link));
    }
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

    <link rel="stylesheet" href="../style/register.css">
</head>
<body>

</body>
</html>
