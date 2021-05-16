<?php

namespace labagarre\src\display\game;
use labagarre\src\model\GameStatus;
use labagarre\src\runner\GameRunner;

class GameDisplay
{

    public static function display(GameRunner $gameRunner) {
        switch($gameRunner->getStatus()) {
            case GameStatus::INITIALIZED: {
                echo "\033[1m\033[34m---------------<A good day for a swell battle! (ง'̀-'́)ง >---------------- \r\n\033[0m";
                break;
            }
            case GameStatus::RUNNING: {
                echo "\r\n";
                echo "\033[1m\033[33m---------------<Round {$gameRunner->getCurrentRoundNumber()}>--------------- \033[0m\r\n";
                break;
            }
            case GameStatus::RUNNING_ROUND: {
                RoundDisplay::display($gameRunner->getRoundRunner());
                break;
            }
            case GameStatus::OVER: {
                echo "\033[1m\033[31m_____________________________________________________________\r\n\r\n ";
                echo "\033[1m La bagarre est finie ! \r\n \r\n \033[0m Le grand gagnant est \033[1m\033[32m{$gameRunner->getWinners()->name}\033[0m avec\033[1m\033[32m {$gameRunner->getWinners()->score}\033[0m points ! \033[1mBravo ! (•̀ᴗ•́)و ̑̑\r\n";
                echo "\033[1m\033[31m_____________________________________________________________\r\n";

            }
        }
    }


}