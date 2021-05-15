<?php

spl_autoload_register(function($className) {
    $className = str_replace("\\", DIRECTORY_SEPARATOR, $className);
    $className = str_replace("labagarre", "./", $className);
    include_once $className . '.php';
});

use labagarre\src\display\menu\MenuDisplay;
use labagarre\src\GameRunner;
use labagarre\src\display\game\GameDisplay;

MenuDisplay::display();
//$players = MenuDisplay::initPlayers();
$gameRunner = new GameRunner();
$gameRunner->init(['a', 'z']);
GameDisplay::display($gameRunner);


while(!$gameRunner->gameIsOver()) {
    $gameRunner->nextStep();
    GameDisplay::display($gameRunner);
    //$continue = '';
    //fscanf(STDIN, '%s', $continue);
}

$gameRunner->end();
GameDisplay::display($gameRunner);

