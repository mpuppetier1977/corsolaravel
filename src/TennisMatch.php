<?php

namespace Abruno\TennisChallenge;

use Abruno\TennisChallenge\interfaces\TennisMatchInterface;
use Abruno\TennisChallenge\traits\TennisMatchTrait;

final class TennisMatch implements TennisMatchInterface {
	use TennisMatchTrait;

	private Player $playerA;
	private Player $playerB;

	/**
	 * @param Player $playerA
	 * @param Player $playerB
	 */
	public function __construct(Player $playerA, Player $playerB) {
		$this->playerA = $playerA;
		$this->playerB = $playerB;
	}

	/**
	 * @return Player
	 */
	public function getPlayerA(): Player {
		return $this->playerA;
	}

	/**
	 * @return Player
	 */
	public function getPlayerB(): Player {
		return $this->playerB;
	}

	/**
	 * @return void
	 */
	public function incrementObjectPlayerAScore(): void {
		$this->playerA->incrementScore();
	}

	/**
	 * @return void
	 */
	public function incrementObjectPlayerBScore(): void {
		$this->playerB->incrementScore();
	}
}