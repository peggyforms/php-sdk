<?php
	namespace PeggyForms\Modules;

	use PeggyForms\Classes;

	class Submissions extends Base {
		public function get(string $submissionHash) : Classes\Submission {
			$result = $this->api->call("Formbuilder.Submissions.getSubmissionByHash", [ "hash" => $submissionHash ]);

			return new Classes\Submission($result->data);
		}

		public function addItem(string $submissionHash, Classes\SubmissionItem $item) {
			$result = $this->api->call("Formbuilder.Submissions.addItem", [ "hash" => $submissionHash, "item" => $item ]);

			return $result;
		}
	}