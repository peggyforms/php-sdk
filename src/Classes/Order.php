<?php
	namespace PeggyForms\Classes;

	class Order {
		public $PaymentType;
		public $InvoiceNumber;
		public $TotalTerms;
		public $TermsInterval;
		public $Amount;
		public $AmountEx;
		public $AmountVat;
		public $VatAmount;
		public $IdVat;
		public $IsIncVat;
		public $IsVatShifted;
		public $Description;
		public $Status;
		public $Modus;
		public $Provider;
		public $Gateway;
		public $CustomerId;
		public $InstallmentId;
		public $SubscriptionId;
		public $Hash;
		public $PaymentDate;
		public $PaymentDetails;
		public $IsInstallment;
		public $OrderLines;

		public function __construct($data) {
			foreach($data as $key => $value) {
				$this->$key = $value;
			}

			$this->OrderLines = array_map([$this, "mapOrderLine"], $this->OrderLines);
			$this->Customer = new Customer($this->Customer);
		}

		protected function mapOrderLine(object $orderLine) : OrderLine {
			return new OrderLine($orderLine);
		}
	}
