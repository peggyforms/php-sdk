<?php
	namespace PeggyForms\Modules\Dynamic;
	use \PeggyForms\Classes;

	trait Webhook {
		public function webhook(bool $success, ?string $message = null) : string {
			$props = $this->getHttpProps($success, [ "message" => $message ]);

			return $this->httpResponse($props);
		}
	}