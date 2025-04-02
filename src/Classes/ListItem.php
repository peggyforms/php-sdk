<?php
	namespace PeggyForms\Classes;

	class ListItem {
		public $key;
		public $value;
		public $checked;
		public $enabled;

		public function __construct($key, $value, $checked = false, $enabled = true) {
			$this->key = $key;
			$this->value = $value;
			$this->checked = $checked;
			$this->enabled = $enabled;
		}
	}