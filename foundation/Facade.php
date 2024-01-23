<?php
/**
 * Class: Facade
 * Created by: LogicaDante mpuppetier@gmail.com
 * Date: 19/01/2024
 * Time: 15:53
 *
 */

namespace Abruno\TennisChallenge\Foundation;

abstract class Facade {
	protected static ?object $resolvedInstance;

	/**
	 * @throws \Exception
	 */
	public static function __callStatic(string $method,array $arguments) {
		//echo "Facade::__callStatic\n";
		$instance = static::getFacadeRoot();
		//echo "Facade::__callStatic chiamata istanza $method \n";
		//var_dump($arguments);
		return $instance->$method(...$arguments);
	}

	/**
	 * @throws \Exception
	 */
	public static function getFacadeRoot() : object{
		//echo "Facade::getFacadeRoot\n";
		if(!isset(static::$resolvedInstance)){
			static::$resolvedInstance = new (static::getFacadeAccessor());
		}
		return static::$resolvedInstance;
	}

	public static function setInstance(?object $instance){
		self::$resolvedInstance = $instance;
	}

	/**
	 * @throws \Exception
	 */
	protected static function getFacadeAccessor(){
		//echo "Facade::getFacadeAccessor\n";
		throw new \Exception('Errore utilizzo classe');
	}
}