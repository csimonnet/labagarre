<?php

namespace labagarre\src\model;

class Player
{
    public $score=0;

    public $name;

    public $deck;

    public function __construct() {
        $this->deck = new Deck();
    }
}