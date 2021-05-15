<?php

namespace labagarre\src\model;


use labagarre\src\display\RoundDisplay;
use labagarre\src\GameStatus;

class Round
{
    private array $cardsPlayed;

    private array $winners;

    public function addCardPlayed(Card $card, Player $player) {
        $this->cardsPlayed[] = [
            'player' => $player,
            'card' => $card
        ];
    }

    public function getWinners() {
        return $this->winners;
    }

    public function getCardsPlayed() {
        return $this->cardsPlayed;
    }

    public function setWinners(array $winners) {
        $this->winners = $winners;
    }
}