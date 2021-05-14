<?php

namespace labagarre\src;

use labagarre\src\model\Player;
use labagarre\src\service\DeckMaster;
use labagarre\src\model\Deck;

class Game
{
    private array $players;

    private Deck $mainDeck;

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
    }

}