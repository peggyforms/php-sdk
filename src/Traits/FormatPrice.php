<?php
	namespace PeggyForms\Traits;

	trait FormatPrice {
		protected function formatPrice($currency, $amount) {
			return $this->getCurrencyHtmlEntity($currency). " ". number_format($amount, 2, ",", ".");
		}

		protected function getCurrencyHtmlEntity($currency, $asHtmlEntity = true) {
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