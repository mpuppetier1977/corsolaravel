<?php
/**
 * Class: Shape
 * Created by: LogicaDante mpuppetier@gmail.com
 * Date: 26/01/2024
 * Time: 12:20
 *
 */

namespace Abruno\TennisChallenge;

use Abruno\TennisChallenge\interfaces\GetArea;

class Shape {
	public GetArea $type;

	public function __construct(GetArea $type) {
		$this->type = $type;
	}

	public function getArea(): float|int {
		return $this->type->getArea();
	}
}


