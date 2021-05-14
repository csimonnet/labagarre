<?php

namespace labagarre\src\model;

class Player
{
    public $score=0;

    public $name;

    public Deck $deck;

    public function __construct() {
        $this->deck = new Deck();
    }

    public function incrementScore() {
        $this->score++;
    }
}