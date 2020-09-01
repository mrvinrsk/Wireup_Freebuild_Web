<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once("../../config/mysql-config.php");
include_once("../../PHP/mc-api.php");

$users_query = "SELECT * FROM Freebuild_RegisteredPlayers;";

if (isset($_POST['username']) && $_POST['username'] != "") {
    $users_query = "SELECT * FROM Freebuild_RegisteredPlayers WHERE UUID = '" . format_uuid(username_to_uuid($_POST['username'])) . "';";
}


$users_statement = $pdo->prepare($users_query);
$users_statement->execute();
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
</head>
<body>

<div id="popup">
    <a href="../../login">Login</a>
</div>

<h1 id="title">Suchst du wen?</h1>
<form id="form" method="post">
    <input type="text" id="search" name="username"
           value="<?php echo((isset($_POST['username']) ? $_POST['username'] : "")); ?>">
    <input type="submit" id="submit" name="submit" value="Suchen">
</form>

<hr>

<script>
    function openStatistics(user) {
        window.location = "../statistiken/index.php?username=" + user;
    }
</script>

<div id="flexcontainer">
    <?php
    if ($users_statement->rowCount() >= 1) {
        while ($row = $users_statement->fetch()) { ?>

            <div class="flexelement list-user-card" onclick="openStatistics('<?php echo(uuid_to_username($row['UUID'])); ?>')">
                <img class="icon mc-head" src="https://minotar.net/helm/<?php echo($row['UUID']); ?>/128.png">
                <h1 class="caption"><?php echo(uuid_to_username($row['UUID'])); ?></h1>
            </div>

            <?php
        }
    } else { ?>

        <div class="flexelement">
            <img class="icon mc-head" src="https://minotar.net/helm/MHF_Question/128.png">
            <h1 class="caption">Niemand gefunden</h1>
        </div>

    <?php } ?>
</div>

</body>
</html>