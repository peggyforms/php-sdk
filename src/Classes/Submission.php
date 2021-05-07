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

		public function getItem($fieldName) {
			if (!isset($this->data->Items->$fieldName)) return null;

			return $this->data->Items->$fieldName;
		}

		public function getOptionValue($fieldName) {
			return $this->get($fieldName, "OptionValue");
		}

		public function get($fieldName, $prop = "Value") {
			$item = $this->getItem($fieldName);
			if (!isset($item) || !isset($item->$prop)) return null;

			return $item->$prop;
		}

		public function getUpsells() : Array {
			return $this->data->Upsells;
		}

		public function getFormKey() : string {
			return $this->data->FormKey;
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
