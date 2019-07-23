<?php
	namespace PeggyForms\Classes;

	class PriceItem {
		use \PeggyForms\Traits\FormatPrice;

		public function __construct($label, $price, $multiplier, $currency = "EUR", $id = null, $orderBy = null) {
			$this->label = $label;
			$this->price = round($price);
			$this->totalPrice = round($price) * $multiplier;
			$this->multiplier = $multiplier;
			$this->currency = $currency;

			$this->priceFormatted = $this->formatPrice($currency, $this->totalPrice / 100);
			$this->id = $id === null ? uniqid() : $id;//md5(implode("-", [ $this->label, $this->price, $this->multiplier]));

			$this->orderBy = $orderBy;
		}
	}