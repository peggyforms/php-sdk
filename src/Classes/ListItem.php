<?php
	namespace PeggyForms\Classes;

	class ListItem {
		public function __construct($key, $value, $checked = false, $enabled = true) {
			$this->key = $key;
			$this->value = $value;
			$this->checked = $checked;
			$this->enabled = $enabled;
		}
	}