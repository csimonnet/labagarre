<?php

namespace labagarre\src;

use labagarre\src\display\game\GameDisplay;
use labagarre\src\model\Deck;
use labagarre\src\model\Game;
use labagarre\src\model\GameStatus;
use labagarre\src\model\Player;
use labagarre\src\service\DeckBuilder;

class GameRunner {

    private Game $game;
    private RoundRunner $roundRunner;
    private Deck $mainDeck;
    private string $status = GameStatus::NOT_INITIALIZED;

    public function __construct() {
        $this->mainDeck = DeckBuilder::buildMainDeck();
    }

    public function init(array $playersNames) {
        $this->game = new Game();
        $this->addPlayers($playersNames);
        $this->roundRunner = new RoundRunner();
        $this->status = GameStatus::INITIALIZED;
        $this->mainDeck->shuffle();
        $this->distributeCards();
    }

    private function addPlayers($playersNames) {
        foreach($playersNames as $playerName) {
            $this->game->addPlayer(new Player($playerName));
        }
    }

    private function distributeCards() {
        $this->mainDeck->shuffle();
        while ($this->mainDeck->hasCards()) {
            foreach($this->game->getPlayers() as $player) {
                if ($this->mainDeck->hasCards()) {
                    $card = $this->mainDeck->takeCard();
                    $player->getDeck()->addCard($card);
                }
            }
        }
        return $this;
    }

    public function gameIsOver(): bool {
        return $this->game->isOver() && $this->roundRunner->getStatus() === GameStatus::OVER;
    }

    public function nextStep() {

        if ($this->roundRunner->getStatus() === GameStatus::NOT_INITIALIZED || $this->roundRunner->getStatus() === GameStatus::OVER) {
            $this->roundRunner->init($this->game->getPlayers());
            $this->status = GameStatus::RUNNING;
        } else if(!$this->roundRunner->isOver()) {
            $this->roundRunner->nextStep();
            $this->status = GameStatus::RUNNING_ROUND;
        } else {
            $this->roundRunner->end();
            $this->game->addRound($this->roundRunner->getRound());
        }
    }

    public function end() {
        $this->computeWinner();
        $this->status = GameStatus::OVER;
    }

    private function computeWinner() {
        $players = $this->game->getPlayers();
        usort($players, function($playerA, $playerB) {
            return $playerA->score <=> $playerB->score;
        });
        $this->game->setWinner($players[count($players) - 1]);
    }

    public function getCurrentRoundNumber() : int{
        return $this->game->getCurrentRoundNumber();
    }

    public function getStatus() {
        return $this->status;
    }

    public function getWinner() {
        return $this->game->getWinner();
    }

    public function getRoundRunner() {
        return $this->roundRunner;
    }
}