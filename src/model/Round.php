<?php

namespace labagarre\src\model;


class Round
{

    private array $cardsPlayed;

    private Player $winner;

    public function addCardPlayed(Card $card, Player $player) {
        $this->cardsPlayed[] = [
            'player' => $player,
            'card' => $card
        ];
    }

    public function __toString() {
        $status = "";
        foreach($this->cardsPlayed as $cardPlayed) {
            $status .= "{$cardPlayed['player']->name} : {$cardPlayed['card']->value} \r\n";
        }
        return $status;
    }

    /**
     * @return Player
     */
    public function getWinner(): Player
    {
        return $this->winner;
    }

    public function computeWinner() {
        $highest = null;
        foreach($this->cardsPlayed as $cardPlayed) {
            $highest = (!isset($highest) || $cardPlayed['card']->value > $highest['card']->value ) ? $cardPlayed : $highest;
        }
        $this->winner = $highest['player'];
        $this->winner->incrementScore();
    }
}