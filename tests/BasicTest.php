<?php

use PHPUnit\Framework\TestCase;
use Abruno\TennisChallenge\Player;
use Abruno\TennisChallenge\services\tennismatch\TennisMatch;
use Abruno\TennisChallenge\Services\Tennismatch\Facade\TennisMatchFacade;

final class BasicTest extends TestCase
{
	public function testTestEnvIsConfigured(): void {
		$this->assertTrue(true);
	}

	// The match starts with both player with the score of "love"
	public function testMatchStartWithBothPlayerLove(): void {
		//$match = $this->getTennisMatch();
		TennisMatchFacade::setInstance(null);
		$playerA = new Player();
		$playerB = new Player();
		TennisMatchFacade::setPlayers($playerA,$playerB);
		//die('fine');
		$this->assertTrue(TennisMatchFacade::getScorePlayerA() == "love" && TennisMatchFacade::getScorePlayerA() == TennisMatchFacade::getScorePlayerB());
	}

	// The scoring system of Tennis increases as follows: "15", "30", "40"
	public function testScoreIncreases15_30_40_PlayerA(): void {

		//$match = $this->getTennisMatch();
		//$match->incrementScorePlayerA();
		TennisMatchFacade::setInstance(null);
		TennisMatchFacade::setPlayers(new Player(),new Player());
/*		TennisMatchFacade::incrementScorePlayerA();
		die('fine');*/
		$this->assertTrue(TennisMatchFacade::incrementScorePlayerA()->getScorePlayerA() == "15");
		$this->assertTrue(TennisMatchFacade::incrementScorePlayerA()->getScorePlayerA() == "30");
		$this->assertTrue(TennisMatchFacade::incrementScorePlayerA()->getScorePlayerA() == "40");
	}

	public function testScoreIncreases15_30_40_PlayerB(): void {

		//$match = $this->getTennisMatch();
		TennisMatchFacade::setInstance(null);
		TennisMatchFacade::setPlayers(new Player(),new Player());
		$this->assertTrue(TennisMatchFacade::incrementScorePlayerB()->getScorePlayerB() == "15", TennisMatchFacade::getScorePlayerB() . ' it is not 15');
		$this->assertTrue(TennisMatchFacade::incrementScorePlayerB()->getScorePlayerB() == "30");
		$this->assertTrue(TennisMatchFacade::incrementScorePlayerB()->getScorePlayerB() == "40");

	}

	// In the simple scenario, a player wins the game if he scores another time after "40"
	public function testScoreIncreases_After40_Game_PlayerA(): void {

		//$match = $this->getTennisMatch();
		TennisMatchFacade::setInstance(null);
		TennisMatchFacade::setPlayers(new Player(),new Player());
		TennisMatchFacade::incrementScorePlayerA()
		      ->incrementScorePlayerA()
		      ->incrementScorePlayerA();

		$this->assertTrue(TennisMatchFacade::incrementScorePlayerA()->getScorePlayerA() == "Game");

	}

	// In the simple scenario, a player wins the game if he scores another time after "40"
	public function testScoreIncreases_After40_Game_PlayerB(): void {

		//$match = $this->getTennisMatch();
		TennisMatchFacade::setInstance(null);
		TennisMatchFacade::setPlayers(new Player(),new Player());
		TennisMatchFacade::incrementScorePlayerB()
		      ->incrementScorePlayerB()
		      ->incrementScorePlayerB();

		$this->assertTrue(TennisMatchFacade::incrementScorePlayerB()->getScorePlayerB() == "Game");

	}

	// If both players reach the score of "40", then they transition into a "deuce" state
	public function testPlayerTransitionIntoDeuce(): void {

		//$match = $this->getTennisMatch();
		TennisMatchFacade::setInstance(null);
		TennisMatchFacade::setPlayers(new Player(),new Player());
		$this->assertFalse(TennisMatchFacade::checkDeuce());

		TennisMatchFacade::incrementScorePlayerB()
		      ->incrementScorePlayerB()
		      ->incrementScorePlayerB();

		$this->assertFalse(TennisMatchFacade::checkDeuce());

		TennisMatchFacade::incrementScorePlayerA()
		      ->incrementScorePlayerA()
		      ->incrementScorePlayerA();

		$this->assertTrue(TennisMatchFacade::getScorePlayerB() == "40");
		$this->assertTrue(TennisMatchFacade::checkDeuce());

	}

	// When the players are in "deuce", if one of them scores he moves to "advantage"
	public function testInDeuceIfScorePlayerGoesInAdvantage(): void {

		//$match = $this->getTennisMatch();
		TennisMatchFacade::setInstance(null);
		TennisMatchFacade::setPlayers(new Player(),new Player());
		$this->assertFalse(TennisMatchFacade::checkDeuce());

		TennisMatchFacade::incrementScorePlayerB()
		      ->incrementScorePlayerB()
		      ->incrementScorePlayerB();

		$this->assertFalse(TennisMatchFacade::checkDeuce());

		TennisMatchFacade::incrementScorePlayerA()
		      ->incrementScorePlayerA()
		      ->incrementScorePlayerA();

		$this->assertTrue(TennisMatchFacade::checkDeuce());

		TennisMatchFacade::incrementScorePlayerA();

		$this->assertTrue(TennisMatchFacade::getScorePlayerA() == "advantage");
		$this->assertFalse(TennisMatchFacade::checkDeuce());

		//Faccio tornare a pari "Deuce" i giocatori
		TennisMatchFacade::incrementScorePlayerB();

		$this->assertTrue(TennisMatchFacade::checkDeuce());

		TennisMatchFacade::incrementScorePlayerB();

		$this->assertTrue(TennisMatchFacade::getScorePlayerB() == "advantage");
		$this->assertFalse(TennisMatchFacade::checkDeuce());

	}

	//If the player with "advantage" scores again, he wins the match
	public function  testIfPlayerWinTheMatchAfterAdvantage(): void {

		//Vittoria playerA
		//$match = $this->getTennisMatch();
		TennisMatchFacade::setInstance(null);
		TennisMatchFacade::setPlayers(new Player(),new Player());
		$this->assertFalse(TennisMatchFacade::checkDeuce());
		TennisMatchFacade::incrementScorePlayerB()
		  ->incrementScorePlayerB()
		  ->incrementScorePlayerB();

		$this->assertFalse(TennisMatchFacade::checkDeuce());
		TennisMatchFacade::incrementScorePlayerA()
		  ->incrementScorePlayerA()
		  ->incrementScorePlayerA();

		$this->assertTrue(TennisMatchFacade::checkDeuce());

		TennisMatchFacade::incrementScorePlayerA();

		$this->assertFalse(TennisMatchFacade::checkDeuce());

		$this->assertTrue(TennisMatchFacade::getScorePlayerA() == "advantage");
		$this->assertFalse(TennisMatchFacade::getScorePlayerB() == "advantage");

		TennisMatchFacade::incrementScorePlayerA();

		$this->assertFalse(TennisMatchFacade::checkDeuce());
		$this->assertTrue(TennisMatchFacade::getScorePlayerA() == "Game");
		$this->assertTrue(TennisMatchFacade::whoIsTheWinner() =='PlayerA');

		//Ora facciamo vincere playerB
		TennisMatchFacade::setInstance(null);
		TennisMatchFacade::setPlayers(new Player(),new Player());
		//$match = $this->getTennisMatch();

		$this->assertFalse(TennisMatchFacade::checkDeuce());

		TennisMatchFacade::incrementScorePlayerB()
		  ->incrementScorePlayerB()
		  ->incrementScorePlayerB();

		$this->assertFalse(TennisMatchFacade::checkDeuce());

		TennisMatchFacade::incrementScorePlayerA()
		  ->incrementScorePlayerA()
		  ->incrementScorePlayerA();

		$this->assertTrue(TennisMatchFacade::checkDeuce());

		TennisMatchFacade::incrementScorePlayerB();

		$this->assertFalse(TennisMatchFacade::checkDeuce());
		$this->assertTrue(TennisMatchFacade::getScorePlayerB() == "advantage");
		$this->assertFalse(TennisMatchFacade::getScorePlayerA() == "advantage");

		TennisMatchFacade::incrementScorePlayerB();

		$this->assertFalse(TennisMatchFacade::checkDeuce());
		$this->assertTrue(TennisMatchFacade::getScorePlayerB() == "Game");
		$this->assertTrue(TennisMatchFacade::whoIsTheWinner() =='PlayerB');
	}

	//If there is one player in "advantage" and the other scores, both return to "deuce"
	public function testIfPlayerIsInAdvantageAndOtherScoreBackToDeuce(): void {
		//$match = $this->getTennisMatch();
		TennisMatchFacade::setInstance(null);
		TennisMatchFacade::setPlayers(new Player(),new Player());
		$this->assertFalse(TennisMatchFacade::checkDeuce());

		TennisMatchFacade::incrementScorePlayerB()
		  ->incrementScorePlayerB()
		  ->incrementScorePlayerB();

		$this->assertFalse(TennisMatchFacade::checkDeuce());

		TennisMatchFacade::incrementScorePlayerA()
		  ->incrementScorePlayerA()
		  ->incrementScorePlayerA();

		$this->assertTrue(TennisMatchFacade::checkDeuce());

		TennisMatchFacade::incrementScorePlayerA();

		$this->assertFalse(TennisMatchFacade::checkDeuce());

		//Ora incremento lo score di playerB per riportare in pareggio
		TennisMatchFacade::incrementScorePlayerB();

		$this->assertTrue(TennisMatchFacade::checkDeuce());

		TennisMatchFacade::incrementScorePlayerB();

		$this->assertFalse(TennisMatchFacade::checkDeuce());
	}



	private function getTennisMatch() : TennisMatch {
		$playerA = new Player();
		$playerB = new Player();

		return new TennisMatch( $playerA, $playerB );
	}
}
