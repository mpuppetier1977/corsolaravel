<?php
/**
 * Class: TennisMatchFacade
 * Created by: LogicaDante mpuppetier@gmail.com
 * Date: 19/01/2024
 * Time: 16:04
 *
 */

namespace Abruno\TennisChallenge\Services\Tennismatch\Facade;
use Abruno\TennisChallenge\Player;
use Abruno\TennisChallenge\Foundation;
use Abruno\TennisChallenge\Services\Tennismatch\TennisMatch;

/**
 * @method static setPlayers(Player $playerA, Player $playerB)
 * @method static getScorePlayerB()
 * @method static getScorePlayerA()
 * @method static incrementScorePlayerA()
 * @method static incrementScorePlayerB()
 * @method static checkDeuce()
 * @method static whoIsTheWinner()
 */
class TennisMatchFacade extends Foundation\Facade {

	protected static function getFacadeAccessor() : string{
		//echo "TennisMatchFacade::getFacadeAccessor\n ";
		return TennisMatch::class;
	}
}