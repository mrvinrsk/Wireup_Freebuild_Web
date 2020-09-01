<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once("../../config/mysql-config.php");
include_once("../../PHP/mc-api.php");


$playername = $_REQUEST['username'];

if (isset($playername)) {
    $uuid = format_uuid(username_to_uuid($playername));

    $money_statement = $pdo->prepare("SELECT * FROM Freebuild_Money WHERE UUID = :uuid");
    $money_execute = $money_statement->execute(array('uuid' => $uuid));
    $money_result = $money_statement->fetch();

    //echo("<script>console.log('Kontostand nicht vorhanden!');</script>");

    $money = "";
    if (!empty($money_statement)) {
        $money = $money_result['Kontostand'];
    }
    $money = str_replace(".", ",", $money);


    $key_statement = $pdo->prepare("SELECT * FROM Freebuild_Mysterykeys WHERE UUID = :uuid");
    $key_execute = $key_statement->execute(array('uuid' => $uuid));
    $key_result = $key_statement->fetch();

    $keys = "";
    if (!empty($key_statement)) {
        $keys = $key_result['Menge'];
    }


    $registered_statement = $pdo->prepare("SELECT * FROM Freebuild_RegisteredPlayers WHERE UUID = :uuid");
    $registered_execute = $registered_statement->execute(array('uuid' => $uuid));
    $registered_result = $registered_statement->fetch();

    $firstPlayedDate = "";
    $firstPlayedTime = "";
    if (!empty($registered_statement)) {
        if (!is_null($registered_result['FirstJoin'])) {
            $firstPlayedDate = date("d.m.Y", ($registered_result['FirstJoin'] / 1000));
            $firstPlayedTime = date("H:i", ($registered_result['FirstJoin'] / 1000));
        }
    }

    $lastPlayedDate = "";
    $lastPlayedTime = "";
    if (!empty($registered_statement)) {
        if (!is_null($registered_result['LastPlayed'])) {
            $lastPlayedDate = date("d.m.Y", ($registered_result['LastPlayed'] / 1000));
            $lastPlayedTime = date("H:i", ($registered_result['LastPlayed'] / 1000));
        }
    }


    $playtime_statement = $pdo->prepare("SELECT * FROM Freebuild_Playtime WHERE UUID = :uuid");
    $playtime_execute = $playtime_statement->execute(array('uuid' => $uuid));
    $playtime_result = $playtime_statement->fetch();

    $playtime = "";
    if (!empty($registered_statement)) {
        $hours = 0;
        $minutes = 0;
        $seconds = 0;

        if (!is_null($playtime_result['Hours'])) {
            $hours = $playtime_result['Hours'];
        }
        if (!is_null($playtime_result['Minutes'])) {
            $minutes = $playtime_result['Minutes'];
        }
        if (!is_null($playtime_result['Seconds'])) {
            $seconds = $playtime_result['Seconds'];
        }
        $playtime = ($hours < 10 ? "0" : "") . $hours . ":" . ($minutes < 10 ? "0" : "") . $minutes . ":" . ($seconds < 10 ? "0" : "") . $seconds . "h";
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
    <title>Freebuild</title>

    <link rel="stylesheet" href="../../style/nutzer.css">
    <link rel="stylesheet" href="../../style/flex.css">
</head>
<body>

<div id="popup">
    <a href="../../login">Login</a>
</div>

<h1 id="title">Wessen Statistiken möchtest du sehen?</h1>
<form id="form" method="post">
    <input type="text" id="search" name="username"
           value="<?php echo((isset($_REQUEST['username']) ? $_REQUEST['username'] : "")); ?>">
    <input type="submit" id="submit" name="submit" value="Suchen">
</form>

<hr>

<div id="flexcontainer">
    <div class="flexelement">
        <img class="icon" src="../../src/icons/money.svg">
        <h1 class="caption">Kontostand</h1>
        <span class="value"><?php echo(((isset($money)) ? (strcmp($money, "") ? $money : "0,00") : "0,00") . "€"); ?></span>
    </div>

    <div class="flexelement">
        <img class="icon" src="../../src/icons/key.svg">
        <h1 class="caption">Mysterykeys</h1>
        <span class="value"><?php echo(((isset($money)) ? (strcmp($money, "") ? $keys : "0") : "0")); ?></span>
    </div>

    <div class="flexelement">
        <img class="icon" src="../../src/icons/calendar.svg">
        <h1 class="caption">Zuerst Gespielt</h1>
        <span class="value"><?php echo(((isset($firstPlayedDate)) ? (strcmp($firstPlayedDate, "") ? $firstPlayedDate : "Nie") : "Nie")); ?></span><br>
        <span class="subvalue"><?php echo(((isset($firstPlayedTime)) ? (strcmp($firstPlayedTime, "") ? $firstPlayedTime . " Uhr" : "") : "")); ?></span>
    </div>

    <div class="flexelement">
        <img class="icon" src="../../src/icons/calendar.svg">
        <h1 class="caption">Zuletzt Gespielt</h1>
        <span class="value"><?php echo(((isset($lastPlayedDate)) ? (strcmp($lastPlayedDate, "") ? $lastPlayedDate : "Nie") : "Nie")); ?></span><br>
        <span class="subvalue"><?php echo(((isset($lastPlayedTime)) ? (strcmp($lastPlayedTime, "") ? $lastPlayedTime . " Uhr" : "") : "")); ?></span>
    </div>

    <div class="flexelement">
        <img class="icon" src="../../src/icons/clock.svg">
        <h1 class="caption">Spielzeit</h1>
        <span class="value"><?php echo(((isset($playtime)) ? $playtime : "Keine")); ?></span><br>
    </div>
</div>

</body>
</html>