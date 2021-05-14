<?php

namespace labagarre\src\display;

use labagarre\src\GameStatus;
use labagarre\src\model\Round;

class RoundDisplay
{

    public static function display(Round $round) {
        switch($round->getStatus()) {
            case GameStatus::OVER: {
                echo $round->getWinner()->name." gagne cette manche et 1 point!";
                break;
            }
            default: {
                foreach($round->getCardsPlayed() as $cardPlayed) {
                    echo $cardPlayed['player']->name." joue la carte ".$cardPlayed['card']->value."\r\n";
                }
            }
        }
    }
}