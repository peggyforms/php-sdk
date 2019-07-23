<?php
	require_once "base.php";

	use PeggyForms\Exceptions;

	class SubmissionTest extends base {
		public function testGetSubmission() {
			try {
				$submission = $this->api->submissions->get($this->settings->submissionHash);
			} catch (Exceptions\InvalidApiResponseException $exception) {
				$this->assertNoPhpError($exception->getData());

				$this->assertJSONResult($exception->getData());
			}

			$this->assertTrue($submission !== null);

	  	}
	}