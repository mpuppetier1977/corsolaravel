<?php
namespace Abruno\TennisChallenge\Tests;
use PHPUnit\Framework\TestCase;
use Abruno\TennisChallenge\Player;
use Abruno\TennisChallenge\services\Tennismatch\TennisMatch;
use Abruno\TennisChallenge\Services\Tennismatch\Facade\TennisMatchFacade;

final class DecoratorPatternTest extends TestCase
{

	public function testDecoratorPattern(): void {

		echo "decorator pattern\r\n";
		$this->assertTrue(true);
	}
}
