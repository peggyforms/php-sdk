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

		public function get(string $fieldName) {
			if (!isset($this->data->Items->$fieldName) || !isset($this->data->Items->$fieldName->Value)) return null;

			return $this->data->Items->$fieldName->Value;
		}

		public function getUpsells() : Array {
			return $this->data->Upsells;
		}

		public function getUpsell(string $name) : ?Object {
			foreach($this->data->Upsells as $upsell) {
				if ($upsell->Name === $name) {
					return $upsell;
				}
			}

			return null;
		}
	}
