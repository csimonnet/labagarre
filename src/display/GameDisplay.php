<?php

namespace labagarre\src\display;

use labagarre\src\Game;
use labagarre\src\GameStatus;

class GameDisplay
{

    public static function display(Game $game) {
        switch($game->getStatus()) {
            case GameStatus::NOT_INITIALIZED: {
                echo "<Répartition des cartes> \r\n";
                break;
            }
            case GameStatus::INITIALIZED: {
                echo "<C'est parti!> \r\n";
                break;
            }
            case GameStatus::RUNNING: {
                echo "<Round {$game->getCurrentRoundNumber()}> \r\n";
                break;
            }
            case GameStatus::OVER: {
                echo "La bagarre est finie ! Le grand gagnant est {$game->getWinner()->name} avec {$game->getWinner()->score} points !";
            }
        }
    }


}