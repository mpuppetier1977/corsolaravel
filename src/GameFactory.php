<?php

namespace TennisChallenge;

class GameFactory {

	public static function create( string $playerName1, string $playerName2 ): IGameManager {

		$gameManager = new GameManager();
		$gameManager->setPlayer1($playerName1);
		$gameManager->setPlayer2($playerName2);

		return $gameManager;
	}

}