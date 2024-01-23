<?php

namespace Abruno\TennisChallenge\Services\Tennismatch;

use Abruno\TennisChallenge\Player;
use Abruno\TennisChallenge\traits\TennisMatchTrait;
use Abruno\TennisChallenge\interfaces\TennisMatchInterface;

final class TennisMatch implements TennisMatchInterface {
	use TennisMatchTrait;

	private Player $playerA;
	private Player $playerB;

	public function setPlayers(Player $playerA, Player $playerB){
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