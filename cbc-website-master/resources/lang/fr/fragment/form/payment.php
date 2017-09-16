<?php
/**
 * Created by PhpStorm.
 * User: Marc
 * Date: 03/07/2015
 * Time: 23:49
 */

return [
	'legend' => 'Information de paiement',
	'input' => [
        'card-type' => 'Type de carte',
		'card-number' => 'Numéro de carte',
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
		'card-number' => 'Pour votre sécurité, cette information n\'est pas conservée sur nos serveurs',
		'expiration' => 'MMAA . Cette information n\'est pas conservée sur nos serveurs',
		'cvv' => 'Trois chiffres au dos de votre carte. Cette information n\'est pas conservée sur nos serveurs.'
	]
];