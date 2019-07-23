<?php
	require_once "base.php";

	abstract class baseDynamic extends base {
		const FormKey = "d8aefc4d";

		abstract protected function getUrl();
		abstract protected function validateResponse($json, $testNumber = null);

		private function validate($json, $testNumber = null) {
			$this->assertNoPhpError($json);
			$json = $this->assertJSONResult($json);

			$this->validateResponse($json, $testNumber);
		}

		protected function parseJson($json) {
			$this->assertNoPhpError($json);
			$this->assertJSONResult($json);

			$parsedUrl = static::DynamicUrl;
			$parsedUrl .= "?idFormElement=". static::IdElement;
			$parsedUrl .= "&formKey=". static::FormKey;

			$urlParts = $this->getUrl();

			if (!is_array($urlParts)) {
				$parsedUrl .= $urlParts;
				$urls = [$parsedUrl];
			} else {
				$urls = [];
				foreach($urlParts as $urlPart) {
					$urls[] = $parsedUrl. $urlPart;
				}
			}

			foreach($urls as $idx => $url) {
				// echo "\n\n$url\n\n";
				$jsonResponse = file_get_contents($url);
				$this->validate($jsonResponse, $idx);
			}

			// echo "\n\n";
			// echo $json;
			// echo "\n\n";
			// echo $jsonResponse;
			// echo "\n\n";
	  	}
	}