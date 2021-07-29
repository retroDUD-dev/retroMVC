<?php

use app\core\form\Form;
use app\core\Application;

?>
<div class="header text">About me</div>
<div class="aboutContainer">
    <div class="about">
        <h3>Hello there!<br>
            And welcome to my page!</h3>

        <h4>Let me tell you a bit about myself:</h4>

        I've always been interested in computers, programming, and technology. I've been in contact with computer science and coding in one form or another since my teen years.<br>
        I followed that path in college, where I studied Physics and Computer Science. My studies gave me a good foundation in World Wide Web basics, basics in database structures and use, as well as programming skills in Python, JavaScript, C++, etc.<br>
        My career path has steered away from programming since college, but I've always remained interested in coding.<br>
        My love for programming was recently reignited and I took up PHP programming, as I would like to build a career in backend web development.<br><br>

        I built this page to test my skills, practice, and hopefully get some feedback.<br>
        I hope that you enjoyed your trip to my page!<br>
        I appreciate any feedback, so if you have any suggestions, questions, or just want to say hello, please feel free to write to <a class="mailtoLink" href="mailto:info@retroDUD.eu">info@retroDUD.eu</a>!<br><br>

        Best,<br>
        retroDUD
    </div>
    <div class="contact">
        <div class="innerContainer">
            CONTACT ME<br><br>
            <div style="text-align: right">
            <?php Form::begin('sendEmail', '', 'post') ?>
            <?php Form::inputField(Application::$APP->model, 'firstName', 'text', 'placeholder="Your name here"') ?>
            <?php Form::inputField(Application::$APP->model, 'lastName', 'text', 'placeholder="Your last name here"') ?>
            <br>
            <?php Form::inputField(Application::$APP->model, 'email', 'email', 'placeholder="Your email here"') ?>
            <br>
            <?php Form::textarea(Application::$APP->model, 'subject', 'style="width: 80%; height:200px;" placeholder="Your message here"') ?>
            </div>
            <?php Form::button(Application::$APP->model, 'submit', 'Submit') ?>
            <?php Form::begin('sendEmail', '', 'post') ?>
        </div>
    </div>
</div>
<div class="submitContainer"></div>