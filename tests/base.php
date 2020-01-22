<?php
	use PHPUnit\Framework\TestCase;

	define("RunningTest", true);

	spl_autoload_register(function ($className) {
		if (strpos($className, "PeggyForms\\") === 0) {
			$path = __DIR__. "/../src/". str_replace("\\", "/", substr($className, 11)). ".php";

			require $path;
		}
	});

	class base extends TestCase {

		protected function setUp() {
			$this->settings = (object)parse_ini_file(__DIR__. "/password");
			$this->auth = base64_encode($this->settings->auth);

			// $hash = $this->settings->submissionHash;
			$apiKey = $this->settings->apiKey;

			$this->api = new PeggyForms\Api($apiKey, "http://formbuilder.local.nl/api");
		}

		// Formbuilder methods
			protected function getFileContentsLoggedIn($url) {
				// $auth = base64_encode(file_get_contents(__DIR__. "/password"));
				$auth = $this->auth;
				$context = stream_context_create(['http' => ['header' => "Authorization: Basic $auth"]]);
				return file_get_contents($url, false, $context);
			}

			protected function submit($url): object {
				$result = $this->getFileContentsLoggedIn($url);

				$this->assertNoPhpError($result);

				$this->assertTrue(
					is_string($result)
				);

				$json = json_decode($result);
				$this->assertTrue(is_object($json), $result);

				return $json;
			}


		// Custom asserts
			protected function assertNoPhpError($str) {
				$this->assertTrue(
					!preg_match("/<b>(notice|warning|fatal error)<\/b>.+\n/i", $str, $matches),
					"Php error:\n". print_r($matches, true)
				);
			}

			protected function assertJSONResult($result) {
				$this->assertTrue(
					is_string($result)
				);

				$json = json_decode($result);
				$this->assertTrue(is_object($json), $result);

				return $json;
			}

			protected function assertValidApiResult($url, $json) {
				$this->assertTrue(
					$json->success && !$json->error,
					(is_string($json->message) ? $json->message : "").
					"\n\nURL: ". $url
				);
			}
	}