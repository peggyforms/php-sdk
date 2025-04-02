<?php
	namespace PeggyForms\Classes;

	class PriceItem {
		use \PeggyForms\Traits\FormatPrice;

		public $type = "price";

		public $id;
		public $label;
		public $price;
		public $totalPrice;
		public $multiplier;
		public $currency;
		public $isMultiItem;
		public $priceFormatted;
		public $orderBy;

		public function __construct($label, $price, $multiplier, $currency = "EUR", $id = null, $orderBy = null, $isMultiItem = false) {
			$this->label = $label;
			$this->price = round($price);
			$this->totalPrice = round($price) * $multiplier;
			$this->multiplier = $multiplier;
			$this->currency = $currency;

			$this->isMultiItem = $isMultiItem;

			$this->priceFormatted = self::formatPrice($currency, $this->totalPrice / 100);
			$this->id = $id === null ? uniqid() : $id;//md5(implode("-", [ $this->label, $this->price, $this->multiplier]));

			$this->orderBy = $orderBy;
		}
	}