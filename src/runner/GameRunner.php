<?php

namespace labagarre\src\runner;

use labagarre\src\model\Deck;
use labagarre\src\model\Game;
use labagarre\src\model\GameStatus;
use labagarre\src\model\Player;
use labagarre\src\service\DeckMaster;

class GameRunner implements Runner {

    private Game $game;
    private RoundRunner $roundRunner;
    private Deck $mainDeck;
    private string $status = GameStatus::NOT_INITIALIZED;

    public function __construct(Deck $mainDeck, RoundRunner $roundRunner) {
        $this->mainDeck = $mainDeck;
        $this->roundRunner = $roundRunner;
    }

    public function init(array $playersNames) {
        $this->game = new Game();
        $this->addPlayers($playersNames);
        $this->status = GameStatus::INITIALIZED;
        DeckMaster::shuffle($this->mainDeck);
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
            //on pourrait juste diviser le paquet en trois... mais ici ça "simule" quelqu'un qui distribuerait des cartes joueur par joueur ;)
            //On peut également envisager de traiter cette méthode dans le DeckMaster et externaliser la distribution des cartes ; ainsi on pourrait avoir un jeu qui utilise potentiellement d'autres distributions.
            foreach($this->game->getPlayers() as $player) {
                if ($this->mainDeck->hasCards()) {
                    $card = $this->mainDeck->takeCard();
                    $player->getDeck()->addCard($card);
                }
            }
        }
        return $this;
    }

    public function isComplete(): bool {
        return $this->game->isComplete() && $this->roundRunner->getStatus() === GameStatus::OVER;
    }

    public function nextStep() {
        if ($this->shouldInitRound()) {
            $this->roundRunner->init($this->game->getPlayers());
            $this->status = GameStatus::RUNNING;
        } else if(!$this->roundRunner->isComplete()) {
            $this->roundRunner->nextStep();
            $this->status = GameStatus::RUNNING_ROUND;
        } else {
            $this->roundRunner->end();
            $this->game->addRound($this->roundRunner->getRound());
        }
    }

    private function shouldInitRound() {
        return ($this->roundRunner->getStatus() === GameStatus::NOT_INITIALIZED || $this->roundRunner->getStatus() === GameStatus::OVER);
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

    public function getWinners() {
        return $this->game->getWinner();
    }

    public function getRoundRunner() {
        return $this->roundRunner;
    }
}