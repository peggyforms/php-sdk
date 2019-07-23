<?php
	require_once "baseDynamic.php";

	use PeggyForms\Exceptions;

	class DatagridResponseTest extends baseDynamic {
		const DynamicUrl = "http://formbuilder.local.nl/api/Formbuilder.Dynamic.getJsonDataForDynamic";
		const AjaxUrl = "http://localhost/formbuilder/posttest/datagrid.php";
		const IdElement = 13193;
		const Columns = "columns[*]";
		const Rows = "rows[*]";

		protected function getUrl() {
			$parsedUrl = "?parsedUrl=". rawurlencode(static::AjaxUrl);
			$parsedUrl .= "&columns=". static::Columns;
			$parsedUrl .= "&rows=". static::Rows;

			return $parsedUrl;
		}

		protected function validateResponse($json, $testNumber = null) {

		}

		public function testDatagridResponse() {
			try {
				$json = $this->api->response->datagrid(
					true,
					[
						new \PeggyForms\Classes\GridColumn("My grid column 1"),
						new \PeggyForms\Classes\GridColumn("My grid column 2"),
						new \PeggyForms\Classes\GridColumn("My grid column 3")
					],
					[
						[
							new \PeggyForms\Classes\GridRowItem("Col row 1 value 1"),
							new \PeggyForms\Classes\GridRowItem("Col row 1 value 2"),
							new \PeggyForms\Classes\GridRowItem("Col row 1 value 3"),
						],
						[
							new \PeggyForms\Classes\GridRowItem("Col row 2value 1"),
							new \PeggyForms\Classes\GridRowItem("Col row 2value 2"),
							new \PeggyForms\Classes\GridRowItem("Col row 2value 3"),
						]
					]
				);

				$jsonObject = $this->assertJSONResult($json);
			} catch (Exceptions\InvalidApiResponseException $exception) {
				$this->assertNoPhpError($exception->getData());

				$jsonObject = $this->assertJSONResult($exception->getData());
			}

			$this->parseJson($json);

			$this->assertTrue(isset($jsonObject->rows));
			$this->assertTrue(isset($jsonObject->columns));
	  	}
	}