<?php
	namespace PeggyForms\Classes;

	class GridRowItem implements \JsonSerializable {
		public function __construct($text) {
			$this->text = $text;
		}

		public function jsonSerialize() {
			return $this->text;
		}
	}