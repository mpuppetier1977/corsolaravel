<?php

namespace Abruno\TennisChallenge\Tests;

use PHPUnit\Framework\TestCase;
use Abruno\TennisChallenge\Shape;
use Abruno\TennisChallenge\Circle;
use Abruno\TennisChallenge\Rectangle;

final class ShapeTest extends TestCase {
	public function testTestEnvIsConfigured(): void {
		$circle = new Circle(4.0);
		$circleShape = new Shape($circle);
		$circleArea = $circleShape->getArea();
		echo $circleArea."\n";

		$rectangle = new Rectangle(4.0,2.0);
		$rectangleShape = new Shape($rectangle);
		$rectangleArea = $rectangleShape->getArea();
		echo $rectangleArea."\n";
		$this->assertTrue(true);
	}
}
