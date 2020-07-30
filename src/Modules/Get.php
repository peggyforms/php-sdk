<?php
	namespace PeggyForms\Modules;

	class Get extends Base {
		public function param(string $name, $default = null) {
			return isset($_REQUEST[$name]) ? $_REQUEST[$name] : $default;
		}

		public function fields() : \Iterator {
			$fields = $this->param("peggy_fields");

			if (!is_array($fields)) return [];

			foreach($fields as $fieldName) {
				$value = $this->param($fieldName);

				// Repeater?
				if (is_array($value) && isset($value["fields"]) && (is_array($value["fields"])) ) {
					foreach($value["fields"] as $repeat => $fields) {
						foreach($fields as $fieldName => $field) {
							yield (object)["name" => $fieldName, "value" => $field["Value"] ];
						}
					}
				} else {
					yield (object)["name" => $fieldName, "value" => $value ];
				}
			}
		}
	}