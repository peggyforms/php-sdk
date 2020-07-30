<?php
	namespace PeggyForms\Modules\Dynamic;
	use \PeggyForms\Classes;

	trait AjaxProxy {
		public function ajaxProxy(bool $success, $data = null) : void {
			$props = $this->getHttpProps($success, $data);

			$this->httpResponse($props);
		}
	}