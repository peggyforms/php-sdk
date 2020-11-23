<?php
	/**
		Version 1.1.11
	*/

	namespace PeggyForms;

	use GuzzleHttp\Client;
	use PeggyForms\Modules;
	use PeggyForms\Classes;
	use PeggyForms\Modules\Dynamic;
	use PeggyForms\Exceptions;

	class Api {
		protected $apiKey;
		protected $accessToken;
		protected $client;

		const EndPointPeggyForms = "https://www.peggyforms.com/api";
		const EndPointPeggyPay = "https://www.peggypay.com/api";

		const Version = "1.1.8";

		public function __construct($apiKey, $endpoint) {

			if (isset($_REQUEST["phpsdklookup"])) {
				die(json_encode((object)["using" => true,"version" => self::Version]));
			}

			$this->loadModules();

			$this->apiKey = $apiKey;

			$endpoint = rtrim($endpoint, "/"). "/";

			$this->client = new Client([
				"base_uri" => $endpoint
			]);

			$url = "";

			$response = $this->client->request("GET", "Framework.authorize", [
				"query" => [
					"method" => "apiKey",
					"apiKey" => $this->apiKey
				],
				"on_stats" => function($stats) use (&$url) {
					$url = $stats->getEffectiveUri();
				}
			]);

			$responseBody = $response->getBody();

			$result = json_decode($response->getBody());
			if (!$result) {
				throw new Exceptions\AuthorizationException("Authorize failed", $responseBody, $url);
			}

			if (!$result->success) {
				throw new Exceptions\AuthorizationException($result->message, $responseBody, $url);
			}

			$this->accessToken = $result->data;
		}

		private function loadModules() {
			$this->submissions = new Modules\Submissions($this);
			$this->response = new Modules\Response($this);
			$this->get = new Modules\Get($this);
		}

		public function call($api, $params) {
			if (isset($this->accessToken) && isset($this->accessToken->Token)) {
				$params["token"] = $this->accessToken->Token;
			}

			$url = "";

			$response = $this->client->request("GET", $api, [
				"query" => $params,
				"on_stats" => function($stats) use (&$url) {
					$url = $stats->getEffectiveUri();
				}
			]);

			// echo $url. "\n";

			$responseBody = $response->getBody();

			$json = $this->validateApiResult($api, $responseBody, $url);

			return $json;
		}

		protected function validateApiResult($api, $responseBody, $url) {
			$json = json_decode($responseBody);

			if (!$json) {
				throw new Exceptions\InvalidApiResponseException("Api failed\n$url: $url\napi: $api", $responseBody, $url);
			}

			if (!$json->success) {
				throw new Exceptions\InvalidApiResponseException("Api call process failed: ". $api. ", message: ". $json->message, $responseBody, $url);
			}

			return $json;
		}

		public function cancelOnInit() {
			$status = $this->get->param("peggy_status");

			if ($status === "init") {
				$this->response->post(
					true
				);
			}
		}
	}