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

    private array $rounds;

    private Round $currentRound;

    public function __construct() {
        $this->mainDeck = DeckMaster::buildMainDeck();
    }

    public function begin(): Game {
        $this->mainDeck->shuffle();
        $this->distributeCards();
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

    public function displayStatus() {
        foreach($this->players as $player) {
            echo "{$player->name} : {$player->score} \r\n";
            $cardsNumber = count($player->deck->getCards());
            echo "Cartes : ({$cardsNumber}) \r\n";
            foreach($player->deck->getCards() as $card) {
                echo "{$card->value},";
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

    public function launchRound() {
        $this->currentRound = new Round();
        $this->displayStatus();
        foreach ($this->players as $player) {
            $cardPlayed = $player->deck->hasCards() ? $player->deck->takeCard() : null;
            $this->currentRound->addCardPlayed($cardPlayed, $player);
        }
        return $this;
    }

    public function displayRoundStatus() {
        echo "Manche en cours: \r\n";
        echo $this->currentRound;
        return $this;
    }

    public function endRound() {
        $this->currentRound->computeWinner();
        echo "Manche terminée : \r\n";
        echo "Gagnant : {$this->currentRound->getWinner()->name}";
        $this->rounds[] = clone $this->currentRound;
        return $this;
    }

}