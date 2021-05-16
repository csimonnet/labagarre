<?php

namespace labagarre\src\runner;

use labagarre\src\model\GameStatus;
use labagarre\src\model\Round;

class RoundRunner implements Runner {

    private Round $round;

    private string $status = GameStatus::NOT_INITIALIZED;

    private array $players = [];

    private array $cardPlayed;

    private array $winners;

    public function init(array $players) {
        $this->players = $players;
        $this->round = new Round();
        $this->status = GameStatus::INITIALIZED;
    }

    public function isComplete(): bool {
        return count($this->players) === 0;
    }

    public function nextStep() {
        $this->status = GameStatus::RUNNING;
        if(!$this->isComplete()) {
            $player = array_shift($this->players);
            $card = $player
                ->getDeck()
                ->takeCard();
            $this->cardPlayed[] = [Round::CARD => $card, Round::PLAYER => $player];
            $this->round->addCardPlayed($card, $player);
        } else {
            throw new \Exception('Everyone has already played in this round.');
        }
    }

    public function end(): void {
        $this->computeWinner();
        $this->round->setWinners($this->winners);
        $this->status = GameStatus::OVER;
    }

    //Peut sans doute être simplifié ou déposé dans un autre service
    private function computeWinner() {
        $highestScore = 0;

        foreach($this->round->getCardsPlayed() as $cardPlayed) {
            $highestScore = $highestScore > $cardPlayed[Round::CARD]->getValue() ? $highestScore : $cardPlayed[Round::CARD]->getValue();
        }

        $highestPlayers = array_values(array_filter($this->round->getCardsPlayed(), function($cardPlayed) use ($highestScore) {
            return $cardPlayed[Round::CARD]->getValue() === $highestScore;
        }));

        $this->winners = array_map(function($cardPlayed) { return $cardPlayed[Round::PLAYER]; }, $highestPlayers);
        foreach($this->winners as $winner) {
            $winner->incrementScore();
        }
        $this->status = GameStatus::OVER;
    }

    public function getRound(): Round {
        return $this->round;
    }

    public function getStatus(): string {
        return $this->status;
    }

    public function getCurrentCardPlayed() {
        return $this->cardPlayed;
    }

    public function getWinners() {
        return $this->winners;
    }

}