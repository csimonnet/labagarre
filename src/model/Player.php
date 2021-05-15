<?php

namespace labagarre\src\model;

class Player
{
    public $score = 0;

    public $name;

    private Deck $deck;

    public function __construct($playerName) {
        $this->deck = new Deck();
        $this->name = $playerName;
    }

    public function incrementScore() {
        $this->score++;
    }

    /**
     * @return int
     */
    public function getScore(): int
    {
        return $this->score;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return Deck
     */
    public function getDeck(): Deck
    {
        return $this->deck;
    }

}