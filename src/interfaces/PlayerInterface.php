<?php

namespace Abruno\TennisChallenge\interfaces;

interface PlayerInterface {
	function getScore() : string;
	function incrementScore() : void;
}