<?php
	namespace PeggyForms\Modules\Dynamic;
	use \PeggyForms\Classes;

	trait Validation {
		public function validation(bool $success, string $validationStatus, ?string $message = null, $data = null) : string {
			$props = $this->getHttpProps($success, $data);

			$props->result = $validationStatus;
			$props->message = $message;

			return $this->httpResponse($props);
		}
	}