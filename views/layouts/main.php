<?php

use app\core\Application;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php $this->title ?></title>

    <link rel="stylesheet" href="https://retroDUD.eu/css/style.css">
    <script type="text/javascript" src="https://retroDUD.eu/js/scripts.js"></script>
</head>

<body>
    <div class="topBar">
        <button class="logo text inner" onclick="window.location.href = '/'"><b>retro</b><img src="https://retroDUD.eu/favicon.ico" class="DUD"></button>
        <button class="AboutMe text inner" onclick="window.location.href = '/AboutMe'">AboutMe</button>

        <?php if (Application::$APP->session->getFlash('success')) : ?>
            <div class="message">
                <?= Application::$APP->session->getFlash('success'); ?>
            </div>
        <?php endif; ?>

        <?php if (Application::isGuest()) : ?>
            <button class="topButton2 text" onclick="window.location.href='/Login'">Log In</button>
            <button class="topButton1 text" onclick="window.location.href='/Register'">Sign Up</button>
        <?php else : ?>
            <?php if (Application::isAdmin()) : ?>
                <button class="topButton3 text" onclick="window.location.href='/Admin'">ADMIN</button>
            <?php endif; ?>
            <button class="topButton2 text" onclick="window.location.href='/MyAccount'">My Account</button>
            <button class="topButton1 text" onclick="window.location.href='/MyAccount/Logout'">(Log Out)</button>
        <?php endif; ?>
    </div>
    <div class="spacer"></div>
    {{content}}
</body>

</html>