<?php
	namespace PeggyForms\Modules\Dynamic;
	use \PeggyForms\Classes;

	trait Choicefield {
		public function choiceField($success, Array $items = null) {
			$items = is_array($items) ? $items : [];

			$props = $this->getHttpProps($success, (object)[
				"items" => $items
			]);

			return $this->httpResponse($props);
		}
	}