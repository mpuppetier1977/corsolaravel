<?php

namespace TennisChallenge;

use Closure;
use Countable;

class PlayersCollection implements Countable {

	private array $arr;

	public function __construct( Player|null ...$players ) {

		$this->arr = $players;

	}

	/**
	 * Returns an item matching with the given index
	 *
	 * @param int $index
	 *
	 * @return Player|null
	 */
	public function get( int $index ): ?Player {

		return array_key_exists($index, $this->arr) ? $this->arr[ $index ] : null;

	}

	/**
	 * Sets an item. Optionally an index can be passed to set it there
	 *
	 * @param Player $player
	 * @param int|null $index
	 *
	 * @return void
	 */
	public function set( Player $player, int | null $index = null ): void {

		if (!is_null($index)) {

			$this->arr[] = $player;

		} else {

			$this->arr[$index] = $player;

		}

	}

	/**
	 * Returns a new PlayerCollection containing items matching with the given filter
	 *
	 * @param Closure $filter_func
	 *
	 * @return PlayersCollection|null
	 */
	public function filter( Closure $filter_func ): PlayersCollection|null {

		$filtered = array_filter( $this->arr, $filter_func );

		$newCollection = new PlayersCollection();

		foreach ( $filtered as $item ) {

			$newCollection->set( $item );

		}

		if ( count( $filtered ) == 0 ) {

			return null;

		}

		return $newCollection;
	}

	/**
	 * Get the first item of the list.
	 *
	 * @return Player
	 */
	public function first(): Player {

		return $this->arr[ array_key_first( $this->arr ) ];

	}

	/**
	 * Implements Countable needs
	 *
	 * @return int
	 */
	public function count(): int {

		return count( $this->arr );

	}
}