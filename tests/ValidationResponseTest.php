<?php
	require_once "baseDynamic.php";

	use PeggyForms\Exceptions;

	class ValidationResponseTest extends baseDynamic {
		const DynamicUrl = "http://formbuilder.local.nl/api/Formbuilder.Dynamic.getJsonDataForValidation";
		const AjaxUrl = "http://82.73.65.130/formbuilder/posttest/validation.php";
		const IdElement = 13191;
		const ValueValid = "12";
		const ValueInvalid = "8";
		const ValueInit = "init";


		const DataPath = "data[*]";
		const Key = "key";
		const Value = "value";
		const SelectionState = "selectionState";
		const EnabledState = "enabledState";

		protected function getUrl() {
			// return "&parsedUrl=". rawurlencode(static::AjaxUrl. "?value=". static::ValueValid);

			$parsedUrls = [
				"&parsedUrl=". rawurlencode(static::AjaxUrl. "?value=". static::ValueValid),
				"&parsedUrl=". rawurlencode(static::AjaxUrl. "?value=". static::ValueInvalid),
				"&parsedUrl=". rawurlencode(static::AjaxUrl. "?value=". static::ValueInit),
			];

			return $parsedUrls;
		}

		protected function validateResponse($json, $testNumber = null) {
			$expectedState = [
				\PeggyForms\Constants\Validation::OK,
				\PeggyForms\Constants\Validation::NOK,
				\PeggyForms\Constants\Validation::INIT
			];

			$this->assertTrue($json->success);
			$this->assertTrue($json->data->success);
			$this->assertTrue($json->data->result === $expectedState[$testNumber]);
		}

		public function testValidationResponse() {
			try {
				$json = $this->api->response->validation(
					true,
					\PeggyForms\Constants\Validation::OK,
					"testMessage",
					[ "value" => 10 ]
				);
			} catch (Exceptions\InvalidApiResponseException $exception) {
				$this->assertNoPhpError($exception->getData());

				$this->assertJSONResult($exception->getData());
			}

			$this->assertNoPhpError($json);
			$this->assertJSONResult($json);

			$this->parseJson($json);
	  	}
	}