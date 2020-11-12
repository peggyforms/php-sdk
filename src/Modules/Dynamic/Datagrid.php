<?php
	namespace PeggyForms\Modules\Dynamic;
	use \PeggyForms\Classes;

	trait Datagrid {
		public function datagrid(bool $success, Array $columns, Array $rows = null) : string {
			$columns = is_array($columns) ? $columns : [];
			$rows = is_array($rows) ? $rows : [];

			$props = $this->getHttpProps($success, (object)[
				"columns" => $columns,
				"rows" => $rows
			]);

			return $this->httpResponse($props);
		}
	}