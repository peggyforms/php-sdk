<?php
	namespace PeggyForms\Modules\Dynamic;

	trait Base {
		protected function getHttpProps($success, $props) {
			// $data = (object)[];

			// $data->data = (object)$props;
			// $data->success = $success;
			// return $data;

			// if (!is_object($props)) {
				$props = (object)$props;
			// }

			$props->success = $success;

			return $props;
		}

		protected function httpResponse($props) {
			if (!defined("RunningTest") || !RunningTest) {
				header("X-Performed-By: PeggyForms SDK");
				header("Content-Type: application/json");
				echo json_encode($props); exit;
			} else {
				return json_encode($props);
			}
		}
	}