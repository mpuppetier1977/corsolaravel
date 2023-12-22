<?php

namespace TennisChallenge;

class StatusSummary {

	private States $machState;

	private Player $player1;

	private Player $player2;

	private Player|null $winner;

	public function __construct( States $machState, Player $player1, Player $player2, Player|null $winner = null ) {

		$this->machState = $machState;
		$this->player1   = $player1;
		$this->player2   = $player2;
		$this->winner    = $winner;
	}

	/**
	 * Gets the match state
	 *
	 * @return States
	 */
	public function getMachState(): States {

		return $this->machState;

	}

	/**
	 * Gets player 1
	 *
	 * @return Player
	 */
	public function getPlayer1(): Player {

		return $this->player1;

	}

	/**
	 * Gets player 2
	 *
	 * @return Player
	 */
	public function getPlayer2(): Player {

		return $this->player2;

	}

	/**
	 * if the match is ended returns the winner
	 *
	 * @return Player|null
	 */
	public function getWinner(): Player|null {

		return $this->winner;

	}

}