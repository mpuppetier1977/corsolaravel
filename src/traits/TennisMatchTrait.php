<?php

namespace Abruno\TennisChallenge\traits;

use Abruno\TennisChallenge\Player;

trait TennisMatchTrait {
	//Se è a true, parte il gioco degli advantage
	private bool $isDeuceGameOn = false;
	private bool $IsPlayerAInAdvantage = false;
	private bool $IsPlayerBInAdvantage = false;
	private ?Player $winner = null;

	/**
	 * @return string
	 */
	public function getScorePlayerA(): string {
		if ($this->isDeuceGameOn && $this->IsPlayerAInAdvantage && is_null($this->winner)) {
			return "advantage";
		}
		return $this->getPlayerA()->getScore();
	}

	/**
	 * @return string
	 */
	public function getScorePlayerB(): string {
		if ($this->isDeuceGameOn && $this->IsPlayerBInAdvantage && is_null($this->winner)) {
			return "advantage";
		}
		return $this->getPlayerB()->getScore();
	}

	/**
	 * @return $this
	 * @throws \Exception
	 */
	public function incrementScorePlayerA(): static {
		$this->checkDeuce();
		if ($this->isDeuceGameOn){
			if($this->IsPlayerBInAdvantage) {
				//Si ritorna a pareggio
				$this->IsPlayerAInAdvantage = false;
				$this->IsPlayerBInAdvantage = false;;
			}else if($this->IsPlayerAInAdvantage){
				//Se non c'è un vincitore il vincitore sono io!!!! Loooooserrrrrr!!!
				if(is_null($this->winner)) {
					//die('nullo');
					$this->incrementObjectPlayerAScore();
					$this->winner = $this->getPlayerA();
				}else{
					throw new \Exception("PlayerA already won the game.");
				}
			}else{
				$this->IsPlayerAInAdvantage = true;
			}
		} else {
			$this->incrementObjectPlayerAScore();
		}

		return $this;
	}

	/**
	 * @return $this
	 * @throws \Exception
	 */
	public function incrementScorePlayerB(): static {
		//All'occorrenza setta isDeuceGameOn
		$this->checkDeuce();

		//Se sono nella fase di gioco Deuce, devo gestire gli advantage e il vincitore
		if ($this->isDeuceGameOn){
			if($this->IsPlayerAInAdvantage){
				//Si ritorna a pareggio
				$this->IsPlayerAInAdvantage = false;
				$this->IsPlayerBInAdvantage = false;
			}else if($this->IsPlayerBInAdvantage){
				//Se non c'è un vincitore il vincitore sono io!!!! Loooooserrrrrr!!!
				if(is_null($this->winner)) {
					$this->incrementObjectPlayerBScore();
					$this->winner = $this->getPlayerB();
				}else{
					throw new \Exception("PlayerB already won the game.");
				}
			}else{
				$this->IsPlayerBInAdvantage = true;
			}
		}else {
			$this->incrementObjectPlayerBScore();
		}
		return $this;
	}

	/**
	 * @return bool
	 */
	public function checkDeuce(): bool{
		if(!$this->isDeuceGameOn && $this->getPlayerA()->getScore() == "40" && $this->getPlayerA()->getScore() == $this->getPlayerB()->getScore()){
			$this->isDeuceGameOn = true;
		}
		return $this->getPlayerA()->getScore() == "40" &&
		  $this->getPlayerA()->getScore() == $this->getPlayerB()->getScore() &&
		  $this->IsPlayerAInAdvantage == false &&
		  $this->IsPlayerBInAdvantage == false ;
	}

	/**
	 * @return string
	 */
	public function whoIsTheWinner(): string{
		$winner = 'None';
		if($this->winner instanceof Player) {
			$winner = ($this->winner === $this->getPlayerA()) ? "PlayerA" : "PlayerB";
		}
		return $winner;
	}
}