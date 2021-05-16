<?php

namespace labagarre\src\runner;

use labagarre\src\model\Card;
use labagarre\src\model\Deck;
use labagarre\src\model\GameStatus;
use PHPUnit\Framework\TestCase;

class GameRunnerTest extends TestCase
{
    protected $roundRunner;
    protected GameRunner $gameRunner;
    protected Deck $mainDeck;

    protected function setUp(): void {
        $this->roundRunner = $this->createMock(RoundRunner::class);
        $this->mainDeck = new Deck();
        $card1 = new Card(1);
        $card2 = new Card(2);
        $this->mainDeck->addCard($card1)
                       ->addCard($card2);
        $this->gameRunner = new GameRunner($this->mainDeck, $this->roundRunner);
    }

    public function testInitShouldInitializeGameStatusAndDistributeCards()
    {

        $this->assertEquals($this->gameRunner->getStatus(), GameStatus::NOT_INITIALIZED);
        $this->gameRunner->init(['Rincevent', 'Vimaire']);
        $this->assertEquals($this->gameRunner->getStatus(), GameStatus::INITIALIZED);
        $this->assertEquals(count($this->mainDeck->getCards()), 0);
    }

    public function testNextStepInitRound()
    {
        $this->gameRunner->init(['Rincevent', 'Vimaire']);
        $this->roundRunner
             ->expects($this->any())
             ->method('getStatus')
             ->will($this->returnValue(GameStatus::NOT_INITIALIZED));

        $this->gameRunner->nextStep();
        $this->assertEquals($this->gameRunner->getStatus(), GameStatus::RUNNING);
    }

    public function testNextStepRunRound() {
        $this->gameRunner->init(['Rincevent', 'Vimaire']);

        $this->roundRunner
            ->expects($this->any())
            ->method('getStatus')
            ->will($this->returnValue(GameStatus::INITIALIZED));
        $this->roundRunner
            ->expects($this->any())
            ->method('isComplete')
            ->will($this->returnValue(false));

        $this->gameRunner->nextStep();
        $this->assertEquals($this->gameRunner->getStatus(), GameStatus::RUNNING_ROUND);
    }

    public function testNextStepEndRound() {
        $this->gameRunner->init(['Rincevent', 'Vimaire']);

        $this->roundRunner
            ->expects($this->any())
            ->method('getStatus')
            ->will($this->returnValue(GameStatus::OVER));
        $this->roundRunner
            ->expects($this->any())
            ->method('isComplete')
            ->will($this->returnValue(true));
        $this->gameRunner->nextStep();
        $this->assertEquals($this->gameRunner->getStatus(), GameStatus::RUNNING);
    }
}
