<?php

namespace labagarre\src\model;

class Deck
{
    private array $cards;

    public function shuffle() {
        shuffle($this->cards);
        return $this;
    }

    public function getCards() {
        return $this->cards;
    }

    public function addCard(Card $card) {
        $this->cards[] = $card;
        return $this;
    }

    public function hasCards() {
        return count($this->cards) > 0;
    }

    public function takeCard() {
        if ($this->hasCards()) {
            return array_pop($this->cards);
        }
        throw new \Exception("deck.empty");
    }

}