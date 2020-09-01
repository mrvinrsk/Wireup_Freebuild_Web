<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once("../config/mysql-config.php");
include_once("../PHP/mc-api.php");

if (!isset($_REQUEST['send'])) {
    header("Location: index.php");
} else {
    $username = $_REQUEST['Username'];
    $UUID = username_to_uuid($username);
    $password = $_REQUEST['Passwort'];

    $register_statement = $pdo->prepare("SELECT * FROM Freebuild_Logins WHERE UUID = :uuid");
    $register_execute = $register_statement->execute(array('uuid' => $UUID));
    $register_result = $register_statement->fetch();

    if ($register_statement->rowCount() == 1) {
        if (password_verify($password, $register_result['Passwort'])) {
            echo("<div class='info'><p>Du wurdest erfolgreich eingeloggt. <a href='../dashboard/index.php'>Zum Dashboard</a></p></div>");
        } else {
            echo("<div class='info'><p>Du hast ein falsches Passwort eingegeben.</p></div>");
        }
    } else {
        echo("<div class='info'><p>Es wurde kein Account mit diesem Usernamen gefunden.</p></div>");
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
    <title>Freebuild - Login</title>

    <link rel="stylesheet" href="../style/login.css">
</head>
<body>

</body>
</html>
