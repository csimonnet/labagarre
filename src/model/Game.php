<?php

namespace labagarre\src;

use labagarre\src\model\Player;
use labagarre\src\model\Round;
use labagarre\src\service\DeckMaster;
use labagarre\src\model\Deck;

class Game
{
    private array $players;

    private Deck $mainDeck;

    private array $rounds = [];

    private Round $currentRound;

    private Player $winner;

    private string $status = GameStatus::NOT_INITIALIZED;

    public function __construct() {
        $this->mainDeck = DeckMaster::buildMainDeck();
    }

    public function begin(): Game {
        $this->mainDeck->shuffle();
        $this->distributeCards();
        $this->status = GameStatus::INITIALIZED;
        return $this;
    }

    public function addPlayer($playerName): Game {
        $player = new Player();
        $player->name = $playerName;
        $this->players[] = $player;
        return $this;
    }

    private function distributeCards() {
        while ($this->mainDeck->hasCards()) {
            foreach($this->players as $player) {
                if ($this->mainDeck->hasCards()) {
                    $card = $this->mainDeck->takeCard();
                    $player->deck->addCard($card);
                }
            }
        }
        return $this;

    }

    public function isOver() {
        foreach($this->players as $player) {
            if(count($player->deck->getCards()) > 0) {
                return false;
            }
        }
        return true;
    }

    public function beginRound() {
        $this->status = GameStatus::RUNNING;
        $this->currentRound = new Round();
        $this->currentRound->begin($this->players);

        return $this;
    }

    public function endRound() {
        $this->currentRound->end();
        $this->rounds[] = clone $this->currentRound;
        return $this;
    }

    public function end() {
        $this->computeWinner();
        $this->status = GameStatus::OVER;
        return $this;
    }

    public function getStatus() {
        return $this->status;
    }

    public function displayRound() {
        $this->currentRound->display();
        return $this;
    }

    public function getCurrentRound() {
        return $this->currentRound;
    }

    public function getCurrentRoundNumber() {
        return count($this->rounds) + 1;
    }

    public function computeWinner() {
        usort($this->players, function($playerA, $playerB) {
            return $playerA->score <=> $playerB->score;
        });
        $this->winner = $this->players[0];
    }

    public function getWinner() {
        return $this->winner;
    }

}