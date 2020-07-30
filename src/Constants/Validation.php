<?php
	namespace PeggyForms\Constants;

	class Validation {
		// Field is valid
		const OK = "OK";

		// Field is invalid
		const NOK = "NOK";

		// Field is valid nor invalid, use this for initial state and not show any error or succes state
		const INIT = "INIT";
	}