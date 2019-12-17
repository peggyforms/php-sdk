<?php
	namespace PeggyForms\Modules;

	use PeggyForms\Classes;

	class Submissions extends Base {
		public function get($submissionHash, $autoDecode = true) {
			$result = $this->api->call("Formbuilder.Submissions.getSubmissionByHash", [ "hash" => $submissionHash ]);

			// if ($autoDecode) {
			// 	foreach($result->data as $key => &$value) {
			// 		$jsonValue = json_decode($value);
	 	// 			if (json_last_error() === JSON_ERROR_NONE) {
	 	// 				$value = $jsonValue;
	 	// 			}
			// 	}
			// }

			return new Classes\Submission($result->data);
		}

		public function addItem($submissionHash, Classes\SubmissionItem $item) {
			$result = $this->api->call("Formbuilder.Submissions.addItem", [ "hash" => $submissionHash, "item" => $item ]);

			return $result;
		}
	}