<?php
	namespace PeggyForms\Modules\Dynamic;
	use \PeggyForms\Classes;

	trait Validation {
		public function validation($success, $validationStatus, $message = null, $data = null) {
			$props = $this->getHttpProps($success, $data);

			$props->result = $validationStatus;
			$props->message = $message;

			return $this->httpResponse($props);
		}
	}