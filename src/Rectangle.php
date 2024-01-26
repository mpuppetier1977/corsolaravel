<?php
/**
 * Class: Rectangle
 * Created by: LogicaDante mpuppetier@gmail.com
 * Date: 26/01/2024
 * Time: 12:31
 *
 */

namespace Abruno\TennisChallenge;

use Abruno\TennisChallenge\interfaces\GetArea;

class Rectangle implements GetArea {
	private float $length;
	private float $width;
	public function __construct(float $length,float $width) {
		$this->length = $length;
		$this->width = $width;
	}
	public function getArea(): float|int {
		return $this->length * $this->width;
	}
}