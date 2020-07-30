<?php
	namespace PeggyForms\Classes;

	class PostReturnAction implements \JsonSerializable {
		protected $action;
		protected $value;

		public function __construct($action, $value = null) {
			$this->action = $action;
			$this->value = $value;
		}

		public function jsonSerialize() {
			return (object)[
				"action" => $this->action,
				"value" => $this->value
			];
		}
	}