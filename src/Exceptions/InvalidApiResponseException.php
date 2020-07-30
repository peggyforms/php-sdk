<?php
	namespace PeggyForms\Exceptions;

	class InvalidApiResponseException extends \Exception {
		protected $data;
		protected $url;

		public function __construct($message, $data, $url) {
			$this->data = $data;
			$this->url = $url;

			parent::__construct($message);
		}

		public function getData() {
			return $this->data;
		}

		public function getUrl() {
			return $this->url;
		}
	}