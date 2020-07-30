<?php
	namespace PeggyForms\Modules\Dynamic;
	use \PeggyForms\Classes;

	trait Pricefield {
		public function pricefield(bool $success, Array $items = null, bool $skipZeroValues = true) : void {
			$items = is_array($items) ? $items : [];

			if ($skipZeroValues) {
				$items = array_values(array_filter($items, function($item) {
					if (!$item) return false;
					if ( $item instanceof Classes\PriceItem && (int)$item->totalPrice <= 0 ) return false;
					if ( $item instanceof Classes\DiscountItem && (int)$item->discount <= 0 ) return false;

					return true;
				}));
			}

			// print_r($items);exit;

			$props = $this->getHttpProps($success, (object)[
				"items" => $items
			]);

			$this->httpResponse($props);
		}
	}