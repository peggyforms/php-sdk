<?php
	namespace PeggyForms\Modules;

	class Get extends Base {
		public function param(string $name, $default = null) {
			return isset($_REQUEST[$name]) ? $_REQUEST[$name] : $default;
		}

		public function fields() : \Iterator {
			$fields = $this->param("peggy_fields");
			$fieldsByProp = $this->param("peggy_fields_by_prop");
			$fieldTypes = $this->param("peggy_field_types");

			if (!is_array($fields)) return [];

			foreach($fields as $fieldName) {
				$prop = $fieldsByProp[$fieldName];
				$value = $this->param($prop);

				// Repeater?
				if (is_array($value) && isset($value["fields"]) && (is_array($value["fields"])) ) {
					foreach($value["fields"] as $repeat => $fields) {
						foreach($fields as $fieldName => $field) {
							$fieldType = $fieldTypes[$fieldName];
							$prop = $fieldsByProp[$fieldName];
							yield (object)["name" => $fieldName, "prop" => $prop, "value" => $field["Value"], "type" => $fieldType, "hasValue" => $this->hasValue($fieldType, $field["Value"]), "amountValue" => $this->amountValue($fieldType, $field["Value"]) ];
						}
					}
					break;
				} else {
					$fieldType = $fieldTypes[$fieldName];
					yield (object)["name" => $fieldName, "prop" => $prop, "value" => $value, "type" => $fieldType, "hasValue" => $this->hasValue($fieldType, $value), "amountValue" => $this->amountValue($fieldType, $value) ];
				}
			}
		}

		public function hasValue(string $fieldType, $value) : bool {
			$amountValue = $this->amountValue($fieldType, $value);

			// var_dump($value);var_dump($fieldType);
			switch($fieldType) {
				// case "price":
				// 	if (empty($value)) return false;
				// 	if ($value["totalPrice"] > 0) return true;
				// 	break;
				case "product":
					return $amountValue > 0;
				// case "checkbox":
				// 	if (empty($value)) return false;
				// 	if (is_array($value) && count($value) > 0) return true;
				// 	break;
				case "upsell":
					return $amountValue === 1;
				// case "choice":
				// 	if (!isset($value) || empty($value)) return false;
				// 	if ($row->fieldValue === $value) return true;
				// 	break;
				case "tiles":
				case "niceChoice": // todo radio etc?
					return !empty($value);
			}

			return false;
		}

		public function amountValue(string $fieldType, $value) : int {
			// var_dump($value);var_dump($fieldType);
			switch($fieldType) {
				// case "price":
				// 	if (empty($value)) return false;
				// 	if ($value["totalPrice"] > 0) return true;
				// 	break;
				case "product":
					if (empty($value) || !is_array($value)) return false;
					if (!isset($value["amount"])) return false; // MY_SPECIAL_DO_NOT_INCLUDE
					return intVal($value["amount"]);
				// case "checkbox":
				// 	if (empty($value)) return false;
				// 	if (is_array($value) && count($value) > 0) return true;
				// 	break;
				case "upsell":
					if (empty($value) || ($value !== true && $value !== "true" && (int)$value !== 1) ) return false;
					return $value === "true" || $value === true || (int)$value === 1 ? 1 : 0;
				// case "choice":
				// 	if (!isset($value) || empty($value)) return false;
				// 	if ($row->fieldValue === $value) return true;
				// 	break;
				case "tiles":
				case "niceChoice": // todo radio etc?
					return !empty($value) ? 1 : 0;
			}

			return false;
		}
	}