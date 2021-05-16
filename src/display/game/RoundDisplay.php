<?php

namespace labagarre\src\display\game;

use labagarre\src\model\GameStatus;
use labagarre\src\model\Round;
use labagarre\src\runner\RoundRunner;

class RoundDisplay
{

    public static function display(RoundRunner $roundRunner) {
        switch($roundRunner->getStatus()) {
            case GameStatus::OVER: {
                $winners=$roundRunner->getWinners();
                if (count($winners) > 1) {
                    echo "Egalité entre ".implode(',', array_map(function($winner) { return $winner[0]->getName();}))."\r\n";
                    echo "Chacun de ces joueurs marque 1 point ! \r\n";
                } else {
                    echo "\033[1m\033[34m{$winners[0]->getName()} gagne cette manche et marque 1 point ! \r\n";
                }
                break;
            }
            case GameStatus::RUNNING: {
                $cardsPlayed = $roundRunner->getCurrentCardPlayed();
                $lastCardPlayed = end($cardsPlayed);
                echo $lastCardPlayed[Round::PLAYER]->name .' tire la carte ' .$lastCardPlayed[Round::CARD]->getValue()."\r\n";
                break;
            }
            case GameStatus::INITIALIZED: {
                break;
            }
        }
    }
}