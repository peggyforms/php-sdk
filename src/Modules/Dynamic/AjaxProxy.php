<?php
	namespace PeggyForms\Modules\Dynamic;
	use \PeggyForms\Classes;

	trait AjaxProxy {
		public function ajaxProxy(bool $success, $data = null) : string {
			$props = $this->getHttpProps($success, $data);

			return $this->httpResponse($props);
		}
	}