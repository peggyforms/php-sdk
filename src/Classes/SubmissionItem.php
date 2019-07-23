<?php
	namespace PeggyForms\Classes;

	class SubmissionItem {
		// Unique string, if exists, will be overwritten
		public $key;

		// Label of the submission
		public $label;

		// Value of the submission
		public $value;

		public function __construct($key, $label, $value) {
			$this->key = $key;
			$this->label = $label;
			$this->value = $value;
		}
	}
