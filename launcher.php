<?php

require_once "autoload.php";

use labagarre\src\display\menu\MenuDisplay;
use labagarre\src\runner\GameRunner;
use labagarre\src\runner\RoundRunner;
use labagarre\src\display\game\GameDisplay;
use labagarre\src\service\DeckMaster;


MenuDisplay::display();
$players = MenuDisplay::initPlayers();

//L'idéal ensuite serait de mettre cette construction dans une factory ou strategy, le launcher n'a pas à savoir tout ça
$gameRunner = new GameRunner(DeckMaster::buildMainDeck(), new RoundRunner());
$gameRunner->init($players);
GameDisplay::display($gameRunner);


while(!$gameRunner->isComplete()) {
    $gameRunner->nextStep();
    GameDisplay::display($gameRunner);
}

$gameRunner->end();
GameDisplay::display($gameRunner);

