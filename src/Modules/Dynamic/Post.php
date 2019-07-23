<?php
	namespace PeggyForms\Modules\Dynamic;
	use \PeggyForms\Classes;

	trait Post {
		public function post($success, Array $props = null, Classes\PostReturnAction $returnAction = null, $exportFields = null) {
			$props = $this->getHttpProps($success, $props);


			if ($returnAction !== null) {
				// if ($returnAction) throw new \PeggyForms\Exceptions\InvalidFuncParam("return action");
				$props->peggyAction = $returnAction;
			}

			if ($exportFields !== null) {
				if (!is_array($exportFields)) throw new \PeggyForms\Exceptions\InvalidFuncParam("export fields");
				$props->exportFields = $exportFields;
			}

			return $this->httpResponse($props);
		}

		public function postReturnAction($action, $value = null) {
			return new Classes\PostReturnAction($action, $value);
		}

		public function exportColumn($columnKey, $columnName, $columnValue) {
			return [ "columnKey" => $columnKey, "columnName" => $columnName, "columnValue" => $columnValue ];
		}
	}