<?php
	namespace PeggyForms\Modules\Dynamic;
	use \PeggyForms\Classes;

	trait Pricefield {
		public function pricefield($success, Array $items = null, $skipZeroValues = true) {
			$items = is_array($items) ? $items : [];

			if ($skipZeroValues) {
				$items = array_values(array_filter($items, function($item) {
					return !!$item && (int)$item->totalPrice !== 0;
				}));
			}

			// print_r($items);exit;

			$props = $this->getHttpProps($success, (object)[
				"items" => $items
			]);

			return $this->httpResponse($props);
		}
	}