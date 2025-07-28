<?php
	namespace PeggyForms\Modules;

	use PeggyForms\Classes;

	class Orders extends Base {
		public function getBySubmissionHash(string $submissionHash) : Classes\Order {
			$result = $this->api->call("Formbuilder.Submissions.getOrder", [ "hash" => $submissionHash, "action" => "getBySubmission" ]);
			// print_r($result->data);exit;

			return new Classes\Order($result->data);
		}

		public function getByOrderHash(string $orderHash) : Classes\Order {
			$result = $this->api->call("Formbuilder.Submissions.getOrder", [ "hash" => $orderHash, "action" => "getByOrder" ]);

			return new Classes\Order($result->data);
		}
	}