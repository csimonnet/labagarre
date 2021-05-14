<?php

namespace labagarre\src\model;


use labagarre\src\display\RoundDisplay;
use labagarre\src\GameStatus;

class Round
{

    private array $cardsPlayed;

    private Player $winner;

    private RoundDisplay $roundDisplay;

    private string $status = GameStatus::NOT_INITIALIZED;

    public function __construct()
    {
        $this->roundDisplay = new RoundDisplay();
    }

    public function begin($players) {
        $this->status = GameStatus::RUNNING;
        foreach ($players as $player) {
            $cardPlayed = $player->deck->hasCards() ? $player->deck->takeCard() : null;
            $this->addCardPlayed($cardPlayed, $player);
        }
    }

    private function addCardPlayed(Card $card, Player $player) {
        $this->cardsPlayed[] = [
            'player' => $player,
            'card' => $card
        ];
    }

    public function end() {
        $highest = null;
        foreach($this->cardsPlayed as $cardPlayed) {
            $highest = (!isset($highest) || $cardPlayed['card']->value > $highest['card']->value ) ? $cardPlayed : $highest;
        }
        $this->winner = $highest['player'];
        $this->winner->incrementScore();
        $this->status = GameStatus::OVER;
    }

    public function getWinner() {
        return $this->winner;
    }

    public function display() {
        $this->roundDisplay->display($this);
        return $this;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getCardsPlayed() {
        return $this->cardsPlayed;
    }
}