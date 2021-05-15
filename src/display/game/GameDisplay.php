<?php

namespace labagarre\src\display\game;
use labagarre\src\model\GameStatus;
use labagarre\src\GameRunner;
use labagarre\src\RoundRunner;

class GameDisplay
{

    public static function display(GameRunner $gameRunner) {
        switch($gameRunner->getStatus()) {
            case GameStatus::NOT_INITIALIZED: {
                echo "<Répartition des cartes> \r\n";
                break;
            }
            case GameStatus::INITIALIZED: {
                echo "<C'est parti!> \r\n";
                break;
            }
            case GameStatus::RUNNING: {
                echo "<Round {$gameRunner->getCurrentRoundNumber()}> \r\n";
                break;
            }
            case GameStatus::RUNNING_ROUND: {
                RoundDisplay::display($gameRunner->getRoundRunner());
                break;
            }
            case GameStatus::OVER: {
                echo "La bagarre est finie ! Le grand gagnant est {$gameRunner->getWinner()->name} avec {$gameRunner->getWinner()->score} points !";
            }
        }
    }


}