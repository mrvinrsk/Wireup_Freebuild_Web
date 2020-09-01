<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once("../config/mysql-config.php");
include_once("../PHP/mc-api.php");


$registered_statement = $pdo->prepare("SELECT * FROM Freebuild_RegisteredPlayers");
$registered_result = $registered_statement->execute(array());
$registered = 0;

while ($row = $registered_statement->fetch()) {
    $registered++;
}


$totalMoney_statement = $pdo->prepare("SELECT SUM(Kontostand) AS total FROM Freebuild_Money;");
$totalMoney_statement->execute();
$totalMoney_result = $totalMoney_statement->fetch();
$totalMoney = $totalMoney_result['total'];
$totalMoney = number_format((float)$totalMoney, 2, ',', '.');

?>

<!doctype html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Freebuild - Statistiken</title>

    <link rel="stylesheet" href="../style/flex.css">
    <link rel="stylesheet" href="../style/statistiken.css">
</head>
<body>

<h1 id="title">Das haben wir erreicht</h1>

<div id="flexcontainer">
    <div class="flexelement">
        <img class="icon" src="../src/icons/user.svg">
        <h1 class="caption">Registrierte Nutzer</h1>
        <span class="value"><?php echo(($registered > 0) ? $registered : "Keine"); ?></span>
    </div>

    <div class="flexelement">
        <img class="icon" src="../src/icons/money.svg">
        <h1 class="caption">Kontostände Summe</h1>
        <span class="value"><?php echo($totalMoney . "€"); ?></span>
    </div>
</div>

</body>
</html>