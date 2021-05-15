<?php
namespace labagarre\tests\runner;

use labagarre\src\model\Card;
use labagarre\src\model\GameStatus;
use labagarre\src\model\Player;
use labagarre\src\runner\RoundRunner;
use PHPUnit\Framework\TestCase;

class RoundRunnerTest extends TestCase
{

    public function testInitialize()
    {
        $player1 = new Player("Rincevent");
        $player2 = new Player("Deux-Fleurs");
        $roundRunner = new RoundRunner();
        $roundRunner->init([$player1, $player2]);
        $this->assertEquals($roundRunner->getStatus(), GameStatus::INITIALIZED);
    }

    public function testNextStepDiscardsCards()
    {
        $player1 = new Player("Rincevent");
        $player2 = new Player("Deux-Fleurs");
        $card1 = new Card();
        $card2 = new Card();
        $card3 = new Card();
        $card4 = new Card();
        $card1->value = 1;
        $card2->value = 2;
        $card3->value = 3;
        $card4->value = 4;

        $player1->getDeck()->addCard($card1);
        $player1->getDeck()->addCard($card2);
        $player2->getDeck()->addCard($card3);
        $player2->getDeck()->addCard($card4);

        $roundRunner = new RoundRunner();
        $roundRunner->init([$player1, $player2]);
        $roundRunner->nextStep();
        $this->assertEquals(GameStatus::RUNNING, $roundRunner->getStatus());
        $this->assertEquals(1, count($player1->getDeck()->getCards()));
        $this->assertEquals(count($player2->getDeck()->getCards()), 2);

        $roundRunner->nextStep();
        $this->assertEquals(count($player1->getDeck()->getCards()), 1);
        $this->assertEquals(count($player2->getDeck()->getCards()), 1);
    }

    public function testIsComplete()
    {
        $player1 = new Player("Rincevent");
        $player2 = new Player("Deux-Fleurs");
        $card1 = new Card();
        $card2 = new Card();
        $card1->value = 1;
        $card2->value = 2;

        $player1->getDeck()->addCard($card1);
        $player2->getDeck()->addCard($card2);

        $roundRunner = new RoundRunner();
        $roundRunner->init([$player1, $player2]);
        $roundRunner->nextStep();
        $this->assertFalse($roundRunner->isComplete());
        $roundRunner->nextStep();
        $this->assertTrue($roundRunner->isComplete());
    }

    public function testNextStepThrowsExceptionIfRoundComplete() {
        $this->expectException(\Exception::class);
        $player1 = new Player("Rincevent");
        $player2 = new Player("Deux-Fleurs");
        $card1 = new Card();
        $card2 = new Card();
        $card1->value = 1;
        $card2->value = 2;

        $player1->getDeck()->addCard($card1);
        $player2->getDeck()->addCard($card2);

        $roundRunner = new RoundRunner();
        $roundRunner->init([$player1, $player2]);
        $roundRunner->nextStep();
        $roundRunner->nextStep();
        $roundRunner->nextStep();
    }

    public function testEnd()
    {
        $player1 = new Player("Rincevent");
        $player2 = new Player("Deux-Fleurs");
        $card1 = new Card();
        $card2 = new Card();
        $card1->value = 1;
        $card2->value = 2;

        $player1->getDeck()->addCard($card1);
        $player2->getDeck()->addCard($card2);

        $roundRunner = new RoundRunner();
        $roundRunner->init([$player1, $player2]);
        $roundRunner->nextStep();
        $roundRunner->nextStep();
        $roundRunner->end();
        $this->assertEquals($roundRunner->getWinners(), [$player2]);
        $this->assertEquals($roundRunner->getWinners()[0]->score, 1);
        $this->assertEquals($roundRunner->getStatus(), GameStatus::OVER);
    }
}
