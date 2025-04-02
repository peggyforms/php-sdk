<?php
	namespace PeggyForms\Classes;

	class DiscountItem {
		use \PeggyForms\Traits\FormatPrice;

		public $type = "discount";

		public $id;
		public $label;
		public $amount;
		public $currency;
		public $orderBy;
		public $discount;
		public $basePriceAmountType;
		public $multiplier;

		public function __construct($label, $amount, $currency = "EUR", $id = null, $orderBy = null) {
			$this->label = $label;


			if (preg_match("/^(\d+)%$/", $amount, $matches)) {
				$basePriceAmountType = "percent";
				$discount = round($matches[1]);
			} else {
				$basePriceAmountType = "int";
				$discount = round($amount);
			}

			$this->discount = $discount;
			$this->basePriceAmountType = $basePriceAmountType;

			$this->multiplier = 1;
			$this->currency = $currency;

			$this->id = $id === null ? uniqid() : $id;

			$this->orderBy = $orderBy;
		}
	}