<?php

require_once './../App.php';

    $autoloader = function ($className)
    {
        echo 'GO';
        require_once "./../Controller/$className.php";
    };

    spl_autoload_register($autoloader);

    $app = new App();
    $app->run();







