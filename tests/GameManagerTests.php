<?php

namespace TennisChallenge\Tests;

use Exception;
use PHPUnit\Framework\TestCase;
use TennisChallenge\GameFactory;
use TennisChallenge\GameManager;
use TennisChallenge\States;

class GameManagerTests extends TestCase {

	/**
	 * just the test setup
	 *
	 * @test
	 */
	public function testSetupIsOk(): void {

		$this->assertTrue( true );

	}

	/**
	 * test: The match starts with both player with the score of "love"
	 *
	 * @test
	 */
	public function matchWillStartWithBothPlayerWithScoreLove(): void {

		$gameManager = GameFactory::create( "p1", "p2" );

		$gameManager->start();

		$statusSummary = $gameManager->getStatusSummary();

		$this->assertTrue( $statusSummary->getMachState() === States::started );

		$player1 = $statusSummary->getPlayer1();
		$player2 = $statusSummary->getPlayer2();

		$this->assertTrue( $player1->getScore() == 'love' );
		$this->assertTrue( $player2->getScore() == 'love' );
	}

	/**
	 * test: The scoring system of Tennis increases as follows: "15", "30", "40"
	 *
	 * @test
	 */
	public function scoringSystemShouldIncreaseWith_15_30_40(): void {

		$gameManager = GameFactory::create( "p1", "p2" );

		$gameManager->start();

		$expectedScores = [ '15', '30', '40' ];

		for ( $i = 0; $i < 3; $i ++ ) {

			$gameManager->scorePlayer1();

			$statusSummary = $gameManager->getStatusSummary();
			$player1       = $statusSummary->getPlayer1();
			$score1        = $player1->getScore();

			$this->assertEquals( $expectedScores[ $i ], $score1 );
		}

		for ( $i = 0; $i < 3; $i ++ ) {

			$gameManager->scorePlayer2();

			$statusSummary = $gameManager->getStatusSummary();
			$player2       = $statusSummary->getPlayer2();
			$score2        = $player2->getScore();

			$this->assertEquals( $expectedScores[ $i ], $score2 );
		}

	}

	/**
	 * test: In the simple scenario, a player wins the game if he scores another time after "40"
	 *
	 * @test
	 */
	public function playerShouldWinIfScoreAnotherTimeAfter_40(): void {

		$gameManager = GameFactory::create( "p1", "p2" );

		$gameManager->start();

		for ( $i = 0; $i <= 3; $i ++ ) {

			$gameManager->scorePlayer1();

			if ( $i == 3 ) {

				$statusSummary = $gameManager->getStatusSummary();

				$winner = $statusSummary->getWinner();

				$this->assertEquals( States::ended, $statusSummary->getMachState() );

				$this->assertNotNull( $winner );

				$this->assertEquals( "p1", $winner->name );

				$this->assertEquals( "game", $winner->getScore() );

			}

		}

	}

	/**
	 * test: If both players reach the score of "40", then they transition into a "deuce" state
	 *
	 * @test
	 */
	public function matchShouldGoInDeuceIfBothPlayerGet_40(): void {

		$gameManager = GameFactory::create( "p1", "p2" );

		$gameManager->start();

		$gameManager->scorePlayer1();
		$gameManager->scorePlayer2();

		$gameManager->scorePlayer1();
		$gameManager->scorePlayer2();

		$statusSummary = $gameManager->getStatusSummary();

		$this->assertNotEquals( States::deuce, $statusSummary->getMachState() );

		$gameManager->scorePlayer1();
		$gameManager->scorePlayer2();

		$statusSummary = $gameManager->getStatusSummary();

		$this->assertEquals( States::deuce, $statusSummary->getMachState() );

	}

	/**
	 * test: When the players are in "deuce", if one of them scores he moves to "advantage"
	 *
	 * @test
	 */
	public function player40ShouldGoInAdvantageWhenMatchIsDeuce_40(): void {

		$gameManager = GameFactory::create( "p1", "p2" );

		$gameManager->start();

		$gameManager->scorePlayer1();
		$gameManager->scorePlayer2();

		$gameManager->scorePlayer1();
		$gameManager->scorePlayer2();

		$gameManager->scorePlayer1();
		$gameManager->scorePlayer2();

		$gameManager->scorePlayer1();

		$statusSummary = $gameManager->getStatusSummary();

		$this->assertEquals( States::started, $statusSummary->getMachState() );

		$this->assertEquals( "advantage", $statusSummary->getPlayer1()->getScore() );
	}

	/**
	 * test: If the player with "advantage" scores again, he wins the match
	 *
	 * @test
	 */
	public function playerShouldWinAfterAdvantage(): void {

		$gameManager = GameFactory::create( "p1", "p2" );

		$gameManager->start();

		$gameManager->scorePlayer1();
		$gameManager->scorePlayer2();

		$gameManager->scorePlayer1();
		$gameManager->scorePlayer2();

		$gameManager->scorePlayer1();
		$gameManager->scorePlayer2();

		$gameManager->scorePlayer1(); #advantage
		$gameManager->scorePlayer1();

		$statusSummary = $gameManager->getStatusSummary();

		$this->assertEquals( States::ended, $statusSummary->getMachState() );

		$this->assertEquals( "game", $statusSummary->getPlayer1()->getScore() );
	}

	/**
	 * test: If there is one player in "advantage" and the other scores, both return to "deuce"
	 *
	 * @test
	 */
	public function playerShouldLoseAdvantageIfTheOtherScores(): void {

		$gameManager = GameFactory::create( "p1", "p2" );

		$gameManager->start();

		$gameManager->scorePlayer1();
		$gameManager->scorePlayer2();

		$gameManager->scorePlayer1();
		$gameManager->scorePlayer2();

		$gameManager->scorePlayer1();
		$gameManager->scorePlayer2();

		$gameManager->scorePlayer1(); #advantage
		$gameManager->scorePlayer2(); #lose advantage

		$statusSummary = $gameManager->getStatusSummary();

		$this->assertEquals( States::deuce, $statusSummary->getMachState() );

		$this->assertEquals( "40", $statusSummary->getPlayer1()->getScore() );
		$this->assertEquals( "40", $statusSummary->getPlayer2()->getScore() );
	}

	/**
	 * a game test
	 *
	 * @test
	 */
	public function gameTest(): void {

		$gameManager = GameFactory::create( "p1", "p2" );

		$gameManager->start();

		$gameManager->scorePlayer1();
		$gameManager->scorePlayer2();

		$gameManager->scorePlayer1();
		$gameManager->scorePlayer2();

		$gameManager->scorePlayer1();
		$gameManager->scorePlayer2();

		$gameManager->scorePlayer1(); #advantage
		$gameManager->scorePlayer2(); #lose advantage
		$gameManager->scorePlayer2(); #advantage

		$statusSummary = $gameManager->getStatusSummary();

		$this->assertEquals( States::started, $statusSummary->getMachState() );
		$this->assertEquals( "advantage", $statusSummary->getPlayer2()->getScore() );

		$gameManager->scorePlayer1(); #lose advantage

		$statusSummary = $gameManager->getStatusSummary();
		$this->assertEquals( States::deuce, $statusSummary->getMachState() );

		$statusSummary = $gameManager->getStatusSummary();

		$this->assertEquals( "40", $statusSummary->getPlayer1()->getScore() );
		$this->assertEquals( "40", $statusSummary->getPlayer2()->getScore() );

		$gameManager->scorePlayer2(); # advantage

		$statusSummary = $gameManager->getStatusSummary();

		$this->assertEquals( "40", $statusSummary->getPlayer1()->getScore() );
		$this->assertEquals( "advantage", $statusSummary->getPlayer2()->getScore() );

		$gameManager->scorePlayer2(); # wins

		$statusSummary = $gameManager->getStatusSummary();

		$this->assertEquals( "40", $statusSummary->getPlayer1()->getScore() );
		$this->assertEquals( "game", $statusSummary->getPlayer2()->getScore() );
		$this->assertEquals( States::ended, $statusSummary->getMachState() );
		$this->assertNotNull( $statusSummary->getWinner() );
	}

	/**
	 * test: cannot start a game without players
	 *
	 * @test
	 */
	public function cannotStartWithoutPlayers(){

		$this->expectException(Exception::class);

		$gameManager = new GameManager();

		$gameManager->start();
	}

	/**
	 * test: cannot start a game without players
	 *
	 * @test
	 */
	public function cannotPlayWithGameNotStarted(){

		$this->expectException(Exception::class);

		$gameManager = GameFactory::create("p1", "p2");

		$gameManager->scorePlayer1();
	}
}

