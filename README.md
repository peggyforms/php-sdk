<img src="https://www.peggyforms.com/app/images/php-sdk.png?7">

Peggy Pay PHP SDK
========

Use this SDK for easy communication with Peggy Pay.

Install
-------
`composer require peggyforms/php-sdk dev-master`

Current version: 1.1.14

Usage
--------

## Init

You have to start always by initialize the PeggyPay object with your API key.
You can find your API key [in your account](https://www.peggyforms.com/account#apikeys)

```php
require "vendor/autoload.php";

$peggyPay = new PeggyForms\Api("myApiKey");
```

### Endpoints:
| Product  | Endpoint constant |
| ------------- | ------------- |
| PeggyPay | PeggyForms\EndPointPeggyPay |
| PeggyForms | PeggyForms\EndPointPeggyForms |

## Get submission by hash

Easily get a submission by its Hash code.

```php
// Get the HTTP request param
$hash = $peggyPay->get->param("submissionHash");

// And get the submission
$submission = $peggyPay->submissions->get($hash);
```

Easily get field submitted value:
```
$submission->get("fieldName");
```

This is the way to get the payment status of an order:

```
$submission->PaymentStatus; // complete/init/error
$submission->PaymentAmount;
```

### Upsells

To get all bought upsells of a submission, use:
```$submission->getUpsells()```

Or if you want to get a purchased upsell by name:

```$submission->getUpsell($yourName)```

## Dynamic content

For plans with AJAX / HTTP features you can:
- populate choicefields, lists, ajax proxy and datagrids.
- create custom field validation
- respond to the POST submit action

### Choicefields

```php
$peggyPay->response->choiceField(
	true, // Call succeded?
	[
		new \PeggyForms\Classes\ListItem(1, "My dynamic option 1"),
		new \PeggyForms\Classes\ListItem(2, "My dynamic option 2")
	]
);
```

### Datagrid
```php
$peggyPay->response->dataGrid(
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
When you need custom valdation, you can use [Javascript](https://www.peggypay.com/kennisbank/overig/js-api/introductie).
Or you can setup to validate via an HTTP request. This example is for validating a field via an HTTP request.

[Read more](https://www.peggypay.com/kennisbank/overig/js-api/introductie)

```php
// Value of the field with the validation
$value = $peggyPay->get->param("value");

// Other fields you added as parameters
$yourFormField1 = $peggyPay->get->param("formfield-1-name");
$yourFormField2 = $peggyPay->get->param("formfield-2-name");

$validated = your_function($value, $yourFormField1, $yourFormField2);

if ($validated === true) {
	$status = \PeggyForms\Constants\Validation::OK;
} elseif ($validated === false) {
	$status = \PeggyForms\Constants\Validation::NOK;
} else {
	$status = \PeggyForms\Constants\Validation::INIT;
}

$peggyPay->response->validation(
	true, // Call succeded
	$status,
	"My nice custom response message",
	[ "prop" => 102 ] // Your custom props for usage in your rules or display as text in your form
);
```

### Populate the Ajax Proxy field

The Ajax Proxy field can be very useful if you have 1 web service which provides multiple data sets.
For example, if your API call returns a list of products and a list of countries, the AJAX proxy field is very useful.
Only 1 HTTP request will be made and all the dependent fields will use this result as data source.

In this example we use typeless objects, but you can use any JSON-serializable object.

```php
$peggyPay->response->ajaxProxy(
	true,
	[
		"products" => [
			(object)[
				"id" => 1,
				"name" => "My product 1"
			],
			..
		],
		"countries" => [
			(object)[
				"id" => 1,
				"name" => "The Netherlands"
			],
			..
		]
	]
);
```

Populate pricefields within ajax proxy:

```
$peggyPay->response->ajaxProxy(
	true,
	[
		// See further this document for specifications for price and discount fields
		"discount" => [ new \PeggyForms\Classes\DiscountItem... ]
	]
);
```

### The POST submit action

This example reacts on the POST submit action. The hash of the submission will always be added as 'submissionHash'.

Use your custom props in your thanks page or email body by writing `{POST:data.StatusMessage}` in the Peggy Pay editor, in example in the [Form] => [Thanks] body:
[Read more](https://www.peggypay.com/kennisbank/apps/webhooks/introductie)

```php

$submissionHash = $peggyPay->get->param("submissionHash");
$field1 = $peggyPay->get->param("field1");
// ...

$statusMessage = your_function($field1); // This example function should return a string with a message

$peggyPay->response->post(
	// Call succeded?
		true,

	// Message to show when call failed,
		$statusMessage,

	// Properties to pass back to your page, to use in your thanks page or email body using {POST:myprop} in this example
		[ "myprop" => 100 ],

	// Optional you can change the thankspage to an redirect
		$peggyPay->post->returnAction(
			\PeggForms\Modules\Post::ReturnActionRedirect,
			"https://www.google.nl"
		),

	// And use some data in the CSV export
		[ $peggyPay->response->exportColumn("uniqueColumnKey", "Column label", $yourValueForExport ) ]
);
```

### Populate the Price field

Price fields are used to collect amounts in your form in a very flexible way.
With dynamic data you also can collect amounts via your webservices via an HTTP request.

Check this screenshot of the price field settings:

```php
// Currency is always passed by Peggy Pay, USD / EUR supported by now
$currency = $peggyPay->get->param("currency", "EUR");

// Optioanlly get some params from Peggy Pay
$amount = (int)$peggyPay->get->param("amount", 1);

// Calculate the amount with your own functions
$price = my_function($amount); // Price should be an integer representing cents
$price2 = my_function_2($amount); // Price should be an integer representing cents

$peggyPay->response->priceField(
	true,
	[
		new \PeggyForms\Classes\PriceItem("My dynamic item", $price, $amount, $currency, "Id"),
		new \PeggyForms\Classes\PriceItem("Administration costs", $price2, 1, $currency, "AdminCosts")
	]
);
```

It is highly recommended to fill the Id parameter if possible.

To populate a Discount field, use:

```php

$peggyPay->response->priceField(
	true,
	[
		new \PeggyForms\Classes\DiscountItem("My dynamic item", $price, $amount, $currency),
	]
);
```