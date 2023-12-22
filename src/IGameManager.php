<?php

namespace TennisChallenge;

interface IGameManager {

	/**
	 * Command to set the player 1
	 *
	 * @param string $name
	 *
	 * @return void
	 */
	public function setPlayer1(string $name): void;

	/**
	 * Command to set the player 1
	 *
	 * @param string $name
	 *
	 * @return void
	 */
	public function setPlayer2(string $name): void;

	/**
	 * Command to start the game
	 *
	 * @return void
	 */
	public function start(): void;

	/**
	 * Command to assign a score to player 1
	 *
	 * @return void
	 */
	public function scorePlayer1(): void;

	/**
	 * Command to assign a score to player 2
	 *
	 * @return void
	 */
	public function scorePlayer2(): void;

	/**
	 * Gets the summary of the game
	 *
	 * @return StatusSummary
	 */
	public function getStatusSummary(): StatusSummary;

}