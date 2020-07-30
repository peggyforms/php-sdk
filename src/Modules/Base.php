<?php
	namespace PeggyForms\Modules;

	class Base {
		protected $api;

		public function __construct($api) {
			$this->api = $api;
		}
	}