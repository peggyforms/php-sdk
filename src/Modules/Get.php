<?php
	namespace PeggyForms\Modules;

	class Get extends Base {
		public function param(string $name, $default = null) {
			return isset($_REQUEST[$name]) ? $_REQUEST[$name] : $default;
		}
	}