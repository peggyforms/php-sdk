<?php
	namespace PeggyForms\Classes;

	class OrderLine {
		public $Description;
		public $ParentDescription;
		public $Type;
		public $Quantity;
		public $Amount;
		public $AmountEx;
		public $AmountTax;
		public $Tax;
		public $IdTax;
		public $IsTaxFree;
		public $IncludeInSubscription;

		public function __construct($data) {
			foreach($data as $key => $value) {
				$this->$key = $value;
			}
		}
	}
