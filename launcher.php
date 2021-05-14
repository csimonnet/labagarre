<?php

spl_autoload_register(function($className) {
    $className = str_replace("\\", DIRECTORY_SEPARATOR, $className);
    $className = str_replace("labagarre", "./", $className);
    include_once $className . '.php';
});

use labagarre\src\Game;
use labagarre\src\display\menu\MenuDisplay;

MenuDisplay::display();
$players = MenuDisplay::initPlayers();


/*$game = new Game();

$game->display()
    ->begin()
    ->display();

while (!$game->isOver()) {
    $game->beginRound()
        ->displayRound()
        ->endRound()
        ->displayRound()
    ;
}

$game->end()
    ->display();*/

