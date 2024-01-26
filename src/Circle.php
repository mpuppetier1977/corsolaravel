<?php
/**
 * Class: Circle
 * Created by: LogicaDante mpuppetier@gmail.com
 * Date: 26/01/2024
 * Time: 12:27
 *
 */

namespace Abruno\TennisChallenge;

use Abruno\TennisChallenge\interfaces\GetArea;

class Circle implements GetArea {
	private float $radius;

	public function __construct(float $radius) {
		$this->radius = $radius;
	}
	public function getArea(): float|int {
		return pow($this->radius,2) * pi();
	}
}