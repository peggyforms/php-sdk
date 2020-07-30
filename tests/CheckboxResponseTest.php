<?php
	require_once "baseDynamic.php";

	use PeggyForms\Exceptions;

	class CheckboxResponseTest extends baseDynamic {
		const DynamicUrl = "http://formbuilder.local.nl/api/Formbuilder.Dynamic.getJsonDataForDynamic";
		const AjaxUrl = "http://localhost/formbuilder/posttest/checkbox.php";
		const IdElement = 13192;
		const DataPath = "data[*]";
		const Key = "key";
		const Value = "value";
		const SelectionState = "selectionState";
		const EnabledState = "enabledState";

		protected function getUrl() {
			$parsedUrl = "?parsedUrl=". rawurlencode(static::AjaxUrl);
			$parsedUrl .= "&dataPath=". static::DataPath;
			$parsedUrl .= "&key=". static::Key;
			$parsedUrl .= "&value=". static::Value;
			$parsedUrl .= "&selectionState=". static::SelectionState;
			$parsedUrl .= "&enabledState=". static::EnabledState;

			return $parsedUrl;
		}

		protected function validateResponse($json, $testNumber = null) {

		}

		public function testCheckboxResponse() {
			try {
				$json = $this->api->response->choiceField(
					true,
					[
						new \PeggyForms\Classes\ListItem(1, "My dynamic option 1", true),
						new \PeggyForms\Classes\ListItem(2, "My dynamic option 2", false, false)
					]
				);

				$jsonObject = $this->assertJSONResult($json);
			} catch (Exceptions\InvalidApiResponseException $exception) {
				$this->assertNoPhpError($exception->getData());

				$jsonObject = $this->assertJSONResult($exception->getData());
			}

			$this->parseJson($json);

			$this->assertTrue(isset($jsonObject->items));
	  	}
	}