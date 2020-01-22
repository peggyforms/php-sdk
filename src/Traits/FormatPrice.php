<?php
	namespace PeggyForms\Traits;

	trait FormatPrice {
		public static function formatPrice($currency, $amount) {
			return self::getCurrencyHtmlEntity($currency). " ". number_format($amount, 2, ",", ".");
		}

		public static function getCurrencyHtmlEntity($currency, $asHtmlEntity = true) {
			switch($currency) {
				case "EUR": $currency = "&euro;"; break;
				case "USD": $currency = "$"; break;
			}

			if (!$asHtmlEntity) {
				$currency = html_entity_decode($currency);
			}


			return $currency;
		}
	}