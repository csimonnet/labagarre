<?php

namespace labagarre\src\service;

use labagarre\src\Configuration;
use labagarre\src\model\Card;
use labagarre\src\model\Deck;

class DeckMaster
{
    public static function buildMainDeck() : Deck{
        $mainDeck = new Deck();
        for($i=1; $i <= Configuration::NB_CARDS; $i++) {
            $card = new Card($i);
            $mainDeck->addCard($card);
        }
        return $mainDeck;
    }

    public static function shuffle(Deck $deck): Deck {
        $deck->shuffle();
        return $deck;
    }

}