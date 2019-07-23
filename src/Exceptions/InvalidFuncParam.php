<?php
	namespace PeggyForms\Exceptions;

	class InvalidFuncParam extends \Exception {
		public function __construct($message) {
			parent::__construct("Invalid $message type");
		}
	}