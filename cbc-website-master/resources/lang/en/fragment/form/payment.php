<?php
/**
 * Created by PhpStorm.
 * User: Marc
 * Date: 03/07/2015
 * Time: 23:49
 */

return [
	'legend' => 'Credit card information',
	'input' => [
        'card-type' => 'Card Type',
		'card-number' => 'Number',
		'expiration' => 'Expiration',
		'cvv' => 'CVV'
	],
    'card-types' => [
        'select' => 'Select...',
        'CB_VISA_MASTERCARD' => 'CB / Visa / Mastercard',
        'MAESTRO' => 'Maestro',
        'DINERS' => 'Diners',
    ],
	'help' => [
		'card-number' => 'This information is not kept on our server',
		'expiration' => 'This information is not kept on our server',
		'cvv' => 'This information is not kept on our server'
	]
];