<?php
	require_once "base.php";

	use PeggyForms\Exceptions;

	class PostResponseTest extends base {
		public function testPostResonse() {
			try {
				$json = $this->api->response->post(
					true,
					"Message",
					[ "prop" => 102 ],
					$this->api->response->postReturnAction(
						\PeggyForms\Constants\Post::ReturnActionRedirect,
						"https://www.google.nl"
					),
					[
						$this->api->response->exportColumn("column", "Column title", 123)
					]
				);
			} catch (Exceptions\InvalidApiResponseException $exception) {
				$this->assertNoPhpError($exception->getData());

				$this->assertJSONResult($exception->getData());
			}

			$this->assertNoPhpError($json);
			$this->assertJSONResult($json);

	  	}
	}