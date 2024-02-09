<?php
/**
 * Class: BasePizza
 * Created by: LogicaDante mpuppetier@gmail.com
 * Date: 26/01/2024
 * Time: 16:05
 *
 */

namespace Abruno\TennisChallenge;

use Abruno\TennisChallenge\interfaces\PizzaContract;

abstract class BasePizza implements PizzaContract {

	abstract public function GetDescription() : string;

	abstract public function GetCost() : float;
}