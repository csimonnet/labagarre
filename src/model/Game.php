<?php

namespace labagarre\src\model;

class Game
{
    private array $players;

    private array $rounds = [];

    private Player $winner;

    private string $status = GameStatus::NOT_INITIALIZED;

    public function __construct() {
    }

    public function addPlayer(Player $player): Game {
        $this->players[] = $player;
        return $this;
    }

    public function isComplete() {
        foreach($this->players as $player) {
            if(count($player->getDeck()->getCards()) > 0) {
                return false;
            }
        }
        return true;
    }


    public function end() {
        $this->status = GameStatus::OVER;
        return $this;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getCurrentRoundNumber() {
        return count($this->rounds) + 1;
    }

    public function getWinner() {
        return $this->winner;
    }

    public function getPlayers() {
        return $this->players;
    }

    public function addRound(Round $round) {
        $this->rounds[] = $round;
    }

    public function setWinner(Player $player) {
        $this->winner = $player;
    }

}