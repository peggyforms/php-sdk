<?php
	namespace PeggyForms\Classes;

	class GridColumn implements \JsonSerializable {
		public function __construct($title) {
			$this->title = $title;
		}

		public function jsonSerialize() {
			return $this->title;
		}
	}