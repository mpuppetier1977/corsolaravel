<?php
/**
 * Class: Pizza
 * Created by: LogicaDante mpuppetier@gmail.com
 * Date: 26/01/2024
 * Time: 16:08
 *
 */

namespace Abruno\TennisChallenge;

class Pizza extends BasePizza {

	public function GetDescription(): string {
		return "Base Pizza Bianca";
	}

	public function GetCost() : float {
		return 5.0;
	}
}

class PizzaIntegrale extends BasePizza{
	public function GetDescription(): string {
		return "Base Integrale";
	}

	public function GetCost() : float {
		return 5.5;
	}
}