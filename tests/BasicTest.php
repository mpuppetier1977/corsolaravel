<?php

use Abruno\TennisChallenge\Player;
use Abruno\TennisChallenge\TennisMatch;
use PHPUnit\Framework\TestCase;

final class BasicTest extends TestCase
{
	public function testTestEnvIsConfigured(): void {
		$this->assertTrue(true);
	}

	// The match starts with both player with the score of "love"
	public function testMatchStartWithBothPlayerLove(): void {
		$match = $this->getTennisMatch();

		$this->assertTrue($match->getScorePlayerA() == "love" && $match->getScorePlayerA() == $match->getScorePlayerB());
	}

	// The scoring system of Tennis increases as follows: "15", "30", "40"
	public function testScoreIncreases15_30_40_PlayerA(): void {

		$match = $this->getTennisMatch();

		$this->assertTrue($match->incrementScorePlayerA()->getScorePlayerA() == "15");
		$this->assertTrue($match->incrementScorePlayerA()->getScorePlayerA() == "30");
		$this->assertTrue($match->incrementScorePlayerA()->getScorePlayerA() == "40");
	}

	public function testScoreIncreases15_30_40_PlayerB(): void {

		$match = $this->getTennisMatch();

		$this->assertTrue($match->incrementScorePlayerB()->getScorePlayerB() == "15", $match->getScorePlayerB() . ' it is not 15');
		$this->assertTrue($match->incrementScorePlayerB()->getScorePlayerB() == "30");
		$this->assertTrue($match->incrementScorePlayerB()->getScorePlayerB() == "40");

	}

	// In the simple scenario, a player wins the game if he scores another time after "40"
	public function testScoreIncreases_After40_Game_PlayerA(): void {

		$match = $this->getTennisMatch();

		$match->incrementScorePlayerA()
		      ->incrementScorePlayerA()
		      ->incrementScorePlayerA();

		$this->assertTrue($match->incrementScorePlayerA()->getScorePlayerA() == "Game");

	}

	// In the simple scenario, a player wins the game if he scores another time after "40"
	public function testScoreIncreases_After40_Game_PlayerB(): void {

		$match = $this->getTennisMatch();

		$match->incrementScorePlayerB()
		      ->incrementScorePlayerB()
		      ->incrementScorePlayerB();

		$this->assertTrue($match->incrementScorePlayerB()->getScorePlayerB() == "Game");

	}

	// If both players reach the score of "40", then they transition into a "deuce" state
	public function testPlayerTransitionIntoDeuce(): void {

		$match = $this->getTennisMatch();

		$this->assertFalse($match->checkDeuce());

		$match->incrementScorePlayerB()
		      ->incrementScorePlayerB()
		      ->incrementScorePlayerB();

		$this->assertFalse($match->checkDeuce());

		$match->incrementScorePlayerA()
		      ->incrementScorePlayerA()
		      ->incrementScorePlayerA();

		$this->assertTrue($match->getScorePlayerB() == "40");
		$this->assertTrue($match->checkDeuce());

	}

	// When the players are in "deuce", if one of them scores he moves to "advantage"
	public function testInDeuceIfScorePlayerGoesInAdvantage(): void {

		$match = $this->getTennisMatch();

		$this->assertFalse($match->checkDeuce());

		$match->incrementScorePlayerB()
		      ->incrementScorePlayerB()
		      ->incrementScorePlayerB();

		$this->assertFalse($match->checkDeuce());

		$match->incrementScorePlayerA()
		      ->incrementScorePlayerA()
		      ->incrementScorePlayerA();

		$this->assertTrue($match->checkDeuce());

		$match->incrementScorePlayerA();

		$this->assertTrue($match->getScorePlayerA() == "advantage");
		$this->assertFalse($match->checkDeuce());

		//Faccio tornare a pari "Deuce" i giocatori
		$match->incrementScorePlayerB();

		$this->assertTrue($match->checkDeuce());

		$match->incrementScorePlayerB();

		$this->assertTrue($match->getScorePlayerB() == "advantage");
		$this->assertFalse($match->checkDeuce());

	}

	//If the player with "advantage" scores again, he wins the match
	public function  testIfPlayerWinTheMatchAfterAdvantage(): void {

		//Vittoria playerA
		$match = $this->getTennisMatch();

		$this->assertFalse($match->checkDeuce());
		$match->incrementScorePlayerB()
		  ->incrementScorePlayerB()
		  ->incrementScorePlayerB();

		$this->assertFalse($match->checkDeuce());
		$match->incrementScorePlayerA()
		  ->incrementScorePlayerA()
		  ->incrementScorePlayerA();

		$this->assertTrue($match->checkDeuce());

		$match->incrementScorePlayerA();

		$this->assertFalse($match->checkDeuce());

		$this->assertTrue($match->getScorePlayerA() == "advantage");
		$this->assertFalse($match->getScorePlayerB() == "advantage");

		$match->incrementScorePlayerA();

		$this->assertFalse($match->checkDeuce());
		$this->assertTrue($match->getScorePlayerA() == "Game");
		$this->assertTrue($match->whoIsTheWinner() =='PlayerA');

		//Ora facciamo vincere playerB
		$match = $this->getTennisMatch();

		$this->assertFalse($match->checkDeuce());

		$match->incrementScorePlayerB()
		  ->incrementScorePlayerB()
		  ->incrementScorePlayerB();

		$this->assertFalse($match->checkDeuce());

		$match->incrementScorePlayerA()
		  ->incrementScorePlayerA()
		  ->incrementScorePlayerA();

		$this->assertTrue($match->checkDeuce());

		$match->incrementScorePlayerB();

		$this->assertFalse($match->checkDeuce());
		$this->assertTrue($match->getScorePlayerB() == "advantage");
		$this->assertFalse($match->getScorePlayerA() == "advantage");

		$match->incrementScorePlayerB();

		$this->assertFalse($match->checkDeuce());
		$this->assertTrue($match->getScorePlayerB() == "Game");
		$this->assertTrue($match->whoIsTheWinner() =='PlayerB');
	}

	//If there is one player in "advantage" and the other scores, both return to "deuce"
	public function testIfPlayerIsInAdvantageAndOtherScoreBackToDeuce(): void {
		$match = $this->getTennisMatch();

		$this->assertFalse($match->checkDeuce());

		$match->incrementScorePlayerB()
		  ->incrementScorePlayerB()
		  ->incrementScorePlayerB();

		$this->assertFalse($match->checkDeuce());

		$match->incrementScorePlayerA()
		  ->incrementScorePlayerA()
		  ->incrementScorePlayerA();

		$this->assertTrue($match->checkDeuce());

		$match->incrementScorePlayerA();

		$this->assertFalse($match->checkDeuce());

		//Ora incremento lo score di playerB per riportare in pareggio
		$match->incrementScorePlayerB();

		$this->assertTrue($match->checkDeuce());

		$match->incrementScorePlayerB();

		$this->assertFalse($match->checkDeuce());
	}


	private function getTennisMatch() : TennisMatch {
		$playerA = new Player();
		$playerB = new Player();

		return new TennisMatch( $playerA, $playerB );

	}
}
