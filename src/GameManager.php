<?php

namespace TennisChallenge;

use Exception;

class GameManager implements IGameManager {

	private States $machState = States::idle;

	private PlayersCollection $players;

	public function __construct() {

		$this->players = new PlayersCollection();

	}

	/**
	 * @inheritDoc
	 *
	 * @throws Exception
	 */
	public function start(): void {

		$this->setMatchState();

	}

	/** @inheritDoc */
	public function setPlayer1(string $name): void {

		$this->players->set(new Player( $name ), 0);

	}

	/** @inheritDoc */
	public function setPlayer2(string $name): void {

		$this->players->set(new Player( $name ), 1);

	}

	/** @inheritDoc */
	public function getStatusSummary(): StatusSummary {

		$p1 = $this->players->get( 0 );
		$p2 = $this->players->get( 1 );

		$winner = $this->getWinner();

		return new StatusSummary( $this->machState,
			!is_null($p1) ? clone $p1 : null,
			!is_null($p2) ? clone $p2 : null,
			$winner );
	}

	/**
	 * @inheritDoc
	 *
	 * @throws Exception
	 */
	public function scorePlayer1(): void {

		$this->managePlayerPoints( 0 );

		$this->setMatchState();

	}

	/**
	 * @inheritDoc
	 *
	 * @throws Exception
	 */
	public function scorePlayer2(): void {

		$this->managePlayerPoints( 1 );

		$this->setMatchState();

	}

	/**
	 * @throws Exception
	 */
	private function managePlayerPoints( int $playerIndex ): void {

		if ($this->machState == States::idle){
			throw new Exception('Cannot play, if the game is not started');
		}

		$player = $this->players->get( $playerIndex );

		$otherPlayer = $this->getOther_player( $playerIndex );

		if ( $otherPlayer->isAdvantage() ) {

			$otherPlayer->increasePoints( - 1 );

			return;

		}

		if ( $player->isLastPoint() ) {

			if ( $this->machState !== States::deuce ) {

				$player->increasePoints( 2 );

				return;

			}

		}

		$player->increasePoints( 1 );
	}

	/**
	 * @throws Exception
	 */
	private function setMatchState(): void {

		$this->ensurePlayers();

		$this->machState = States::started;

		$isEnded = $this->getPlayersWithFinalPoint();

		if ( $isEnded ) {

			$this->machState = States::ended;

		} else {

			$player1 = $this->players->get( 0 );
			$player2 = $this->players->get( 1 );

			if ( $player1->hasSameScore($player2) && $player1->isLastPoint()) {

				$this->machState = States::deuce;

			}
		}
	}

	private function getWinner(): Player|null {

		if ( $this->machState === States::ended ) {

			$winners = $this->getPlayersWithFinalPoint();

			if ( $winners ) {

				return $winners->first();

			}

		}

		return null;
	}

	private function getOther_player( int $playerIndex ): Player {

		$otherPlayerIndex = intval( ! $playerIndex );

		return $this->players->get( $otherPlayerIndex );
	}

	private function getPlayersWithFinalPoint(): PlayersCollection|null {

		return $this->players->filter( function ( Player $p ) {

			return $p->isFinalPoint();

		} );

	}

	/**
	 * @return void
	 * @throws Exception
	 */
	public function ensurePlayers(): void {

		if ( count( $this->players ) < 2 )
			throw new Exception( 'Not enough players to start a game' );

	}
}