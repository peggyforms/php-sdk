<?php
	namespace PeggyForms\Classes;

	class GridRowItem implements \JsonSerializable {
		public $text;

		public function __construct($text) {
			$this->text = $text;
		}

		public function jsonSerialize() {
			return $this->text;
		}
	}