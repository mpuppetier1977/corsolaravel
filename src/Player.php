<?php

namespace Abruno\TennisChallenge;

use Abruno\TennisChallenge\interfaces\PlayerInterface;

class Player implements PlayerInterface{

	private int $score = 0;
	private array $scoresLabel = ["love", "15", "30", "40", "Game"];

	/**
	 * @return string
	 */
	public function getScore(): string {
		return $this->scoresLabel[$this->score];
	}

	/**
	 * @return void
	 */
	public function incrementScore(): void {
		$this->score ++;
	}
}