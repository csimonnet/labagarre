<?php

namespace labagarre\src\model;

class Round
{
    const PLAYER = 'player';
    const CARD = 'card';
    private array $cardsPlayed;

    public function addCardPlayed(Card $card, Player $player) {
        $this->cardsPlayed[] = [
            self::PLAYER => $player,
            self::CARD => $card
        ];
    }

    public function getCardsPlayed() {
        return $this->cardsPlayed;
    }

    public function setWinners(array $winners) {
        $this->winners = $winners;
    }
}