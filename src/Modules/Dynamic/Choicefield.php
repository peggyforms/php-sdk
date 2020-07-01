<?php
	namespace PeggyForms\Modules\Dynamic;
	use \PeggyForms\Classes;

	trait Choicefield {
		public function choiceField(bool $success, Array $items = null) : void {
			$items = is_array($items) ? $items : [];

			$props = $this->getHttpProps($success, (object)[
				"items" => $items
			]);

			$this->httpResponse($props);
		}
	}