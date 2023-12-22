<?php

namespace Abruno\TennisChallenge\interfaces;

use Abruno\TennisChallenge\Player;

interface TennisMatchInterface {
	/**
	 * Ritorna il punteggio del playerA
	 * @return string
	 */
	function getScorePlayerA(): string ;

	/**
	 * Ritorna il punteggio del playerB
	 * @return string
	 */
	function getScorePlayerB(): string ;

	/**
	 * Incrementa il punteggio del playerA
	 * @return $this
	 */
	function incrementScorePlayerA(): static;

	/**
	 * Incrementa il punteggio del playerB
	 * @return $this
	 */
	function incrementScorePlayerB(): static;

	/**
	 * Controlla se si è in pareggio (fase deuce)
	 * @return bool
	 */
	function checkDeuce(): bool;

	/**
	 * Ritorna chi è il vincitore
	 * @return string
	 */
	function whoIsTheWinner(): string;

	/**
	 * Ritorna il playerA
	 * @return Player
	 */
	function getPlayerA(): Player;

	/**
	 * Ritorna il playerB
	 * @return Player
	 */
	function getPlayerB(): Player;

	/**
	 * Chiede al match di aumentare il punteggio del playerA
	 * @return void
	 */
	function incrementObjectPlayerAScore():void;

	/**
	 * Chiede al match di aumentare il punteggio del playerB
	 * @return void
	 */
	function incrementObjectPlayerBScore():void;
}