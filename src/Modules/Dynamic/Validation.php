<?php
	namespace PeggyForms\Modules\Dynamic;
	use \PeggyForms\Classes;

	trait Validation {
		public function validation(bool $success, string $validationStatus, string $message = null, $data = null) : void {
			$props = $this->getHttpProps($success, $data);

			$props->result = $validationStatus;
			$props->message = $message;

			$this->httpResponse($props);
		}
	}