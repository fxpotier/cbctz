<?php
/**
 * Created by PhpStorm.
 * User: Marc
 * Date: 09/07/2015
 * Time: 16:13
 */

return [
	"meta" => [
		"title" => "My Experiences",
		"description" => "My Experiences description",
	],
    'message'=> [
        'title' => 'One little remark...',
		'banking-link' => 'banking information',
        'banking-missing' => 'You need to fill your <a href=":link">:message</a> to submit an experience for online validation. This is so that you can be payed upon reservation :).'
    ],
	'edit-experience' => 'Edit experience',
	'edit-calendar' => 'Edit calendar',
	'delete' => 'Delete',
	'put' => 'Put',
	'tips' => 'Want some tips about how to create experience and improve<br/>your profile ?',
	'here' => 'It’s all here',
	'title' => 'Hey ! So... You want to design a new experience ? GREAT, let\'s start',
	'submit' => 'Send to validation<br/>	and edit calendar',
	'modal'=> [
		'title' => 'Delete an experience',
		'content' => 'Are you sure you want to delete this experience ?',
		'validate' => 'Yes',
		'cancel' => 'No'
	],
	'state' => [
		'online' => 'online',
		'offline' => 'offline',
		'validating' => 'on validation',
		'creating' => 'on creation',
	],
	'about' => [
		'legend' => 'What about this experience',
		'input' => [
			'title' => 'First, we need a title',
			'title-translate' => 'Translate your title',
			'content' => 'Then, there is the description',
			'description-translate' => 'Translate your description',
			'languages' => 'Languages available',
			'language-add'=> 'Add a language',
			'tags' => 'Tags',
			'tags-add' => 'Add a tag',
			'transportation' => 'Transportation',
			'transportation-add' => 'Add a mean of transportation'
		],
		'help' => [
			'title' => 'It is important to have a good title because it is the first thing that travelers read about your experience',
			'content' => 'Tell us why you offer this experience and what it is all about: where are you taking the travelers and why. It should make people want to book right after reading it',
			'languages' => 'Add all others languages available for this experience',
			'tags' => 'Choose some words - 3 to 6 is good - that describe best your experience',
			'transportation' => 'What mean(s) of transportation will you use ?'
		]
	],
	'place' => [
		'legend' => 'Where does your experience takes place ?',
		'input' => [
			'first-city' => 'First City',
			'second-city' => 'Second Cities',
			'second-city-add' => 'Add another city',
			'country' => 'Your Country',
			'distance' => 'Max distance area'
		],
		'help' => [
			'first-city' => 'The place your experience is happening',
			'second-city' => 'If you city is not very well known, write here the nearest major cities',
			'country' => 'There\'s a city called Paris in Texas... We just want to avoid any confusion',
			'distance' => 'Indicate the max distance covered by your expedience from the center of the town'
		]
	],
	'meeting' => [
		'legend' => 'Meeting point',
		'legend-help' => 'It\'s better if you can find each other',
	],
	'practical' => [
		'legend' => 'Practical information',
		'input' => [
			'min-travelers' => 'Min. travelers',
			'max-travelers' => 'Max. travelers',
			'duration' => 'Duration',
			'days' => 'days',
			'hours' => 'hours',
			'minutes' => 'minutes',
			'meeting-point' => 'Meeting point',
			'address' => 'address',
			'city' => 'city'
		],
		'help' => [
			'min-travelers' => 'Maybe your experience require a minimal amount of travelers',
			'max-travelers' => 'Sometimes we just can\'t offer an experience to a group of 15 people',
			'duration' => ''
		]
	],
	'price' => [
		'legend' => 'Pricing',
		'input' => [
			'tips' => 'Suggested tips',
			'food' => 'Food costs',
			'transportation' => 'Transportation costs',
			'ticket' => 'Tickets costs',
			'other' => 'Others costs',
			'per-person' => 'Per person'
		],
		'help' => [
			'tips' => 'After your experience, travelers should give you some tips. You can suggest a price'
		]
	],
	'picture' => [
		'legend' => 'We want some great pictures',
		'legend-help' => 'One picture is worth a thousand words ! In order to finish designing your experience, your have to upload some nice pictures (in a great resolution if possible). It would be perfect if they could show places you will visit or activites you will do in the experience.',
		'choose' => 'Choose picture',
		'resize' => 'Resize',
		'delete' => 'Delete',
		'modal' => [
			'title' => 'Resize the picture',
			'ok' => 'Ok',
			'cancel' => 'Cancel'
		],
		'input' => [
			'main' => 'Thumbnail picture',
			'description' => 'Description pictures',
			'cover' => 'Cover picture'
		],
		'help' => [
			'main' => 'Travelers are going to see this picture first - With the summary of the experience you propose',
			'description' => 'To illustrate your description',
			'cover' => 'Introduces your experience'
		]
	]
];