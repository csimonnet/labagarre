<?php

namespace labagarre\src\service;

use labagarre\src\model\Card;
use labagarre\src\model\Deck;

class DeckMaster
{

    const CARDS_NUMBER = 52;

    public static function buildMainDeck() : Deck{
        $mainDeck = new Deck();
        for($i=1; $i <= self::CARDS_NUMBER; $i++) {
            $card = new Card();
            $card->value = $i;
            $mainDeck->addCard($card);
        }
        return $mainDeck;
    }

}