<?php
/**
 * Class: Product
 * Created by: LogicaDante mpuppetier@gmail.com
 * Date: 23/01/2024
 * Time: 08:46
 *
 */

namespace Abruno\TennisChallenge;

class Product {
	public string $name;
	public float $price;
	public int $quantity;

	public function __construct(string $name, float $price, int $quantity) {
		$this->name = $name;
		$this->price = $price;
		$this->quantity = $quantity;
	}

	public function calculateTotalPrice() : float {
		$discountedPrice = $this->applyDiscount($this->price);
		$taxedPrice = $this->applyTax($discountedPrice);
		$totalPrice = $this->applyShipping($taxedPrice);

		return $totalPrice;
	}

	private function applyDiscount(float $price) : float {
		// Applica uno sconto al prezzo
		return $price * 0.9;
	}

	private function applyTax(float $price) : float {
		// Applica una tassa al prezzo
		return $price * 1.08;
	}

	private function applyShipping($price) : float {
		// Aggiunge il costo della spedizione al prezzo
		return $price + 5;
	}
}

// Utilizzo della classe
$product = new Product('Laptop', 1000, 2);
$totalPrice = $product->calculateTotalPrice();
echo "Il prezzo totale è: $totalPrice";