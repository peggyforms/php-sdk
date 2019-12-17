<?php
	namespace PeggyForms\Classes;

	class Submission {
		protected $data;

		const flatProps = ["DateAdded", "PaymentStatus", "PaymentAmount"];

		public function __construct($data) {
			foreach(self::flatProps as $prop) {
				if (isset($data->$prop)) {
					$this->$prop = $data->$prop;
				}
			}

			$this->data = $data;
		}

		public function get($fieldName) {
			if (!isset($this->data->Items->$fieldName) || !isset($this->data->Items->$fieldName->Value)) return null;

			return $this->data->Items->$fieldName->Value;
		}
	}
