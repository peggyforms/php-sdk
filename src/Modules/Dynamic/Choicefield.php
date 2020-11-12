<?php
	namespace PeggyForms\Modules\Dynamic;
	use \PeggyForms\Classes;

	trait Choicefield {
		public function choiceField(bool $success, Array $items = null) : string {
			$items = is_array($items) ? $items : [];

			$props = $this->getHttpProps($success, (object)[
				"items" => $items
			]);

			return $this->httpResponse($props);
		}
	}