<?php
	namespace PeggyForms\Classes;

	class Customer {
		public $FirstName;
		public $LastName;
		public $Email;
		public $CompanyName;
		public $VATNumber;
		public $Address;
		public $Website;
		public $BankAccount;
		public $Phone;
		public $FullName;

		public function __construct($data) {
			foreach($data as $key => $value) {
				$this->$key = $value;
			}
		}
	}
