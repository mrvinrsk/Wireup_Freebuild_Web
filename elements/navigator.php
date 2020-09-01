<link rel="stylesheet" href="/Freebuild/style/navigator.css">

<ul id="navigator">
    <?php
    if (isset($_SESSION['userID'])) {
        echo("<li><a href=\"/knowme/account/dashboard\">Dashboard</a></li>");
        echo("<li><a href=\"/knowme/matchgame\">Match Game</a></li>");
        echo("<li><a href=\"/knowme/account/logout\">Ausloggen</a></li>");
    } else {
        echo("<li><a href=\"/knowme/account/login\">Account</a></li>");
    }
    ?>
</ul>

<!-- <script>
    document.addEventListener('scroll', function () {
        var y = window.pageYOffset;
        var navigator = document.getElementById('navigator');

        if (y >= 200) {
            if (!navigator.classList.contains("scrolled")) {
                navigator.classList.add("scrolled");
            }
        } else {
            if (navigator.classList.contains("scrolled")) {
                navigator.classList.remove("scrolled");
            }
        }
    });
</script> -->