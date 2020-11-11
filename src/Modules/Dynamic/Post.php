<?php
	namespace PeggyForms\Modules\Dynamic;
	use \PeggyForms\Classes;

	trait Post {
		public function post(bool $success, string $message = null, Array $props = null, Classes\PostReturnAction $returnAction = null, $exportFields = null) : void {
			$props = $this->getHttpProps($success, $props);
			$props->message = $message;

			if ($returnAction !== null) {
				// if ($returnAction) throw new \PeggyForms\Exceptions\InvalidFuncParam("return action");
				$props->peggyAction = $returnAction;
			}

			if ($exportFields !== null) {
				if (!is_array($exportFields)) throw new \PeggyForms\Exceptions\InvalidFuncParam("export fields");
				$props->exportFields = $exportFields;
			}

			$this->httpResponse($props);
		}

		public function postReturnAction(string $action, ?string $value = null) : Classes\PostReturnAction {
			return new Classes\PostReturnAction($action, $value);
		}

		public function exportColumn(string $columnKey, string $columnName, $columnValue, ?string $columnType = \PeggyForms\Constants\Post::ExportColumnTypeString) : Array {
			return [ "columnKey" => $columnKey, "columnName" => $columnName, "columnValue" => $columnValue, "columnType" => $columnType ];
		}
	}