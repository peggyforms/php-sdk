Peggy Forms PHP SDK
========

Use this SDK for easy communication with Peggy Forms.

Install
-------
`composer require peggyforms/php-sdk dev-master`

Usage
--------

## Init

You have to start always by initialize the PeggyForms object with your API key.
You can find your API key [in your account](https://www.peggyforms.com/account#apikeys)

```php
require "vendor/autoload.php";

$peggyForms = new PeggyForms\Api("myApiKey", PeggyForms::EndPointPeggyForms);
```

### Endpoints:
| Product  | Endpoint constant |
| ------------- | ------------- |
| PeggyForms | PeggyForms\EndPointPeggyForms |
| PeggyPay | PeggyForms\EndPointPeggyPay |

## Get submission by hash

Easily get a submission by its Hash code.

```php
// Get the HTTP request param
$hash = $peggyForms->get->param("submissionHash");

// And get the submission
$submission = $peggyForms->submissions->get($hash);
```

This is also the way to get the payment status of an order. Payment forms wil have [paymentStatus] and [paymentAmount] added in the submission data.

## Dynamic content

For plans with AJAX / HTTP features you can:
- populate choicefields, lists, ajax proxy and datagrids.
- create custom field validation
- respond to the POST submit action

[Read more](https://www.peggyforms.com/features/integrations-webhooks-ajax/how-to-integrations-postsubmit)

### Choicefields

```php
$peggyForms->response->choiceField(
	true, // Call succeded?
	[
		new \PeggyForms\Classes\ListItem(1, "My dynamic option 1"),
		new \PeggyForms\Classes\ListItem(2, "My dynamic option 2")
	]
);
```

### Datagrid
```php
$peggyForms->response->dataGrid(
	true, // Call succeded?
	[ // The columns
		new \PeggyForms\Classes\GridColumn("My grid column 1"),
		new \PeggyForms\Classes\GridColumn("My grid column 2"),
		new \PeggyForms\Classes\GridColumn("My grid column 3")
	],
	[ // And the rows with items
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
```

### Validation

You can validate your form fields using the default validation tools in the editor.
When you need custom valdation, you can use [Javascript](https://www.peggyforms.com/features/javascript-api#validation).
Or you can setup to validate via an HTTP request. This example is for validating a field via an HTTP request.

[Read more](https://www.peggyforms.com/features/inputvalidation)

SCREENSHOTTODO HOWTO in peggy

```php
// Value of the field with the validation
$value = $peggyForms->get->param("value");

// Other fields you added as parameters
$yourFormField1 = (int)$peggyForms->get->param("yourFormField1");
$yourFormField2 = (int)$peggyForms->get->param("yourFormField2");

$validated = your_function($yourFormField1, $yourFormField2);

if ($validated === true) {
	$status = \PeggyForms\Constants\Validation::OK;
} elseif ($validated === false) {
	$status = \PeggyForms\Constants\Validation::NOK;
} else {
	$status = \PeggyForms\Constants\Validation::INIT;
}

$peggyForms->response->validation(
	true, // Call succeded
	$status,
	"My nice custom response message",
	[ "prop" => 102 ] // Your custom props for usage in your rules or display as text in your form
);
```

### Populate the Ajax Proxy field

The Ajax Proxy field can be very useful if you have 1 web service which provides multiple data sets.
Only 1 HTTP request will be made and all the dependent fields will use this result as data source.

```php
$peggyForms->response->ajaxProxy(
	true,
	[
		"dataSet1" => [], // .. complete dataset
		"dataSet2" => [] // .. complete dataset
	]
);
```

### The POST submit action

This example reacts on the POST submit action. The hash of the submission will always be added as 'submissionHash'.

Use your custom props in your thanks page or email body by writing `{POST:data.StatusMessage}`


[Read more](https://www.peggyforms.com/features/integrations-webhooks-ajax/how-to-integrations-postsubmit#postwebhook)

```php

$submissionHash = $peggyForms->get->param("submissionHash");
$field1 = $peggyForms->get->param("field1");
// ...

$statusMessage = your_function($field1); // This example function should return a string with a message

$peggyForms->post->response(
	true, // Call succeded?
	[ "StatusMessage" => $statusMessage ], // Your custom props for usage in the thanks page or email
	$peggyForms->post->returnAction( // Optional you can change the thankspage to an redirect
		\PeggForms\Modules\Post::ReturnActionRedirect,
		"https://www.google.nl"
	)
);
```

### Populate the Price field

Price fields are used to collect amounts in your form in a very flexible way.
With dynamic data you also can collect amounts via your webservices via an HTTP request.

READMORE TODO

SCREENSHOTTODO HOWTO in peggy

```php
// Currency is always passed by Peggy Forms, USD / EUR supported by now
$currency = $peggyForms->get->param("currency", "EUR");

// Optioanlly get some params from Peggy Forms
$amount = (int)$peggyForms->get->param("amount", 1);

// Calculate the amount with your own functions
$price = my_function($amount); // Price should be an integer representing cents

$peggyForms->response->priceField(
	true,
	[
		new \PeggyForms\Classes\PriceItem("My dynamic item", $price, $amount, $currency),
		new \PeggyForms\Classes\PriceItem("My dynamic item TAX", $price * .21, 1, $currency)
	]
);
```