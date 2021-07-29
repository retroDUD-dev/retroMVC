<?php

use app\core\Application;

?>
<script>
    txt = "Welcome to my page<?php if (!Application::isGuest()) : echo ', ' . Application::$APP->session->get('user')['displayName']; endif; ?>!\n\nAs part of my introduction to PHP, I decided to create a website that allows you to create and store DnD characters.\nYou should have the option to save your character locally, print out a character sheet, or save it online.\n\nPlease do keep in mind that this is a work in progress and that I only just begun my journey into PHP so not everything may work as expected.\n\nAlright, so how would you like to proceed?";
    i = 0;
    skip = false;
    document.addEventListener("keyup", function(event) {
        if (event.keyCode === 13) {
            skip = true;
        }
    });
</script>
<div id="skip"><button class="submit skip" onclick="skip = true">SKIP</button></div>
<div class="header text">Hello there, weary traveller!</div>
<div class="container">
    <textarea id="output" class="text" style="width: 85%; text-align: center; resize: none; background-color: var(--background-color); border: 0px;" rows="1" disabled></textarea>
</div>
<div id="hidden" class="containerBottom">
    <div class="col left">
        <button class="submit button" onclick="window.location.href = '/CreateNewCharacter'">Create new character</button>
    </div>
    <div class="col right">
        <button class="submit button" onclick="window.location.href = '/MyAccount'">To my account</button>
    </div>
</div>
<img src="" onerror="typing()">