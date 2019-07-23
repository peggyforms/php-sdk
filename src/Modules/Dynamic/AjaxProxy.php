<?php
	namespace PeggyForms\Modules\Dynamic;
	use \PeggyForms\Classes;

	trait AjaxProxy {
		public function ajaxProxy($success, $data = null) {
			$props = $this->getHttpProps($success, $data);

			return $this->httpResponse($props);
		}
	}