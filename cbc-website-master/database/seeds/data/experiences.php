<?php
/**
 * Created by PhpStorm.
 * User: Marc
 * Date: 13/06/2015
 * Time: 12:10
 */

return [
	[
		'data' => [
			'duration_days' => 5,
			'duration_hours' => 2,
			'duration_minutes' => 30,
			'min_persons' => 1,
			'max_persons' => 2,
			'incurred_cost' => 40,
			'incurred_transportation_cost' => 10,
			'incurred_food_drink_cost' => 10,
			'incurred_ticket_cost' => 10,
			'incurred_other_cost' => 10,
			'incurred_cost_per_person' => 0,
			'incurred_transportation_cost_per_person' => 0,
			'incurred_food_drink_cost_per_person' => 0,
			'incurred_ticket_cost_per_person' => 0,
			'incurred_other_cost_per_person' => 0,
			'suggested_tip' => 35,
			'is_experience_per_person' => false,
			'state' => 'ONLINE'
		],
		'language_aliases' => ['en', 'fr', 'de'],
		'area' => [
			'data' => [
				'range' => 100
			],
			'address' => [
				'street' => '73 rue Ferdinand Buisson',
				'zipcode' => '69003',
				'city' => 'Lavanville',
				'country' => 'Kanto',
				'latitude' => 45.750065,
				'longitude' => 4.889845
			]
		],
		'meetingPoint' => [
			'street' => '142 Avenue Berthelot',
			'zipcode' => '69007',
			'city' => 'Lavanville',
			'country' => 'Kanto',
			'latitude' => '45.742513',
			'longitude' => '4.849713'
		],
		'cover' => 'imgExperienceTest.jpg',
		'userMail' => 'm.gavanier@gmail.com',
		'descriptions' => [
			[
				'lang' => 'en',
				'data' => [
					'title' => 'Visit of the Pokémon Tower',
					'content' => 'Content Description - Lorem ipsum dolor sit amet, consectetur adipiscing elit. In placerat, nibh et interdum faucibus, lorem nunc rhoncus neque, id efficitur ex urna a lorem. Suspendisse potenti. Praesent lorem lorem, semper a diam eu, dignissim mollis odio. Quisque consequat purus ut nibh pellentesque, eget iaculis dui hendrerit. Duis accumsan venenatis varius. Pellentesque eu urna nisl. Vestibulum id ligula ut tellus molestie vehicula pulvinar id turpis. Vivamus a mollis orci. Vivamus vulputate orci ac sem congue scelerisque molestie eu nunc. Ut varius lorem eu massa fringilla iaculis. Donec tristique dui non massa bibendum, id venenatis tellus suscipit. Maecenas vehicula, lacus id consectetur suscipit, lorem libero bibendum turpis, vel dignissim lectus sem eu augue.'
				]
			],
			[
				'lang' => 'fr',
				'data' => [
					'title' => 'Visite de la tour Pokémon',
					'content' => 'Description du contenu - Lorem ipsum dolor sit amet, consectetur adipiscing elit. In placerat, nibh et interdum faucibus, lorem nunc rhoncus neque, id efficitur ex urna a lorem. Suspendisse potenti. Praesent lorem lorem, semper a diam eu, dignissim mollis odio. Quisque consequat purus ut nibh pellentesque, eget iaculis dui hendrerit. Duis accumsan venenatis varius. Pellentesque eu urna nisl. Vestibulum id ligula ut tellus molestie vehicula pulvinar id turpis. Vivamus a mollis orci. Vivamus vulputate orci ac sem congue scelerisque molestie eu nunc. Ut varius lorem eu massa fringilla iaculis. Donec tristique dui non massa bibendum, id venenatis tellus suscipit. Maecenas vehicula, lacus id consectetur suscipit, lorem libero bibendum turpis, vel dignissim lectus sem eu augue.'
				]
			],
			[
				'lang' => 'de',
				'data' => [
					'title' => 'Besuch des Pokémon -Turm',
					'content' => 'Das kontenu deskription - Lorem ipsum dolor sit amet, consectetur adipiscing elit. In placerat, nibh et interdum faucibus, lorem nunc rhoncus neque, id efficitur ex urna a lorem. Suspendisse potenti. Praesent lorem lorem, semper a diam eu, dignissim mollis odio. Quisque consequat purus ut nibh pellentesque, eget iaculis dui hendrerit. Duis accumsan venenatis varius. Pellentesque eu urna nisl. Vestibulum id ligula ut tellus molestie vehicula pulvinar id turpis. Vivamus a mollis orci. Vivamus vulputate orci ac sem congue scelerisque molestie eu nunc. Ut varius lorem eu massa fringilla iaculis. Donec tristique dui non massa bibendum, id venenatis tellus suscipit. Maecenas vehicula, lacus id consectetur suscipit, lorem libero bibendum turpis, vel dignissim lectus sem eu augue.'
				]
			]
		],
		'partners' => [
			[
				'data' => [
					'name' => 'Google',
					'link' => 'http://www.google.com'
				],
				'picture' => 'partnerTest.jpg'
			]
		],
		'rates' => [
			[
				'data' => [ 'value' => 4 ],
				'userMail' => 'm.gavanier@gmail.com'
			],
			[
				'data' => [ 'value' => 3 ],
				'userMail' => 'romain.cambonie@gmail.com'
			]
		],
		'tags' => [
			["name" => "mystery"],
			["name" => "fear"],
			["name" => "adventure"],
			["name" => "danger"]
		]
	],
	[
		'data' => [
			'duration_days' => 0,
			'duration_hours'=> 1,
			'duration_minutes' => 15,
			'min_persons' => 1,
			'max_persons' => 2,
			'incurred_cost' => 8.5,
			'incurred_transportation_cost' => 0,
			'incurred_food_drink_cost' => 8.5,
			'incurred_ticket_cost' => 0,
			'incurred_other_cost' => 0,
			'incurred_cost_per_person' => 0,
			'incurred_transportation_cost_per_person' => 0,
			'incurred_food_drink_cost_per_person' => 0,
			'incurred_ticket_cost_per_person' => 0,
			'incurred_other_cost_per_person' => 0,
			'suggested_tip' => 10.5,
			'is_experience_per_person' => false,
			'state' => 'ONLINE'
		],
		'language_aliases' => ['en', 'fr'],
		'area' => [
			'data' => [
				'range' => 100
			],
			'address' => [
				'street' => '73 rue Ferdinand Buisson',
				'zipcode' => '69003',
				'city' => 'Forina',
				'country' => 'Hoenn',
				'latitude' => 45.750065,
				'longitude' => 4.889845
			]
		],
		'meetingPoint' => [
			'street' => '142 Avenue Berthelot',
			'zipcode' => '69007',
			'city' => 'Forina',
			'country' => 'Hoenn',
			'latitude' => '45.742513',
			'longitude' => '4.849713'
		],
		'cover' => 'imgExperienceTest.jpg',
		'userMail' => 'romain.cambonie@gmail.com',
		'descriptions' => [
			[
				'lang' => 'en',
				'data' => [
					'title' => 'A walk in Forina',
					'content' => 'Content Description - Lorem ipsum dolor sit amet, consectetur adipiscing elit. In placerat, nibh et interdum faucibus, lorem nunc rhoncus neque, id efficitur ex urna a lorem. Suspendisse potenti. Praesent lorem lorem, semper a diam eu, dignissim mollis odio. Quisque consequat purus ut nibh pellentesque, eget iaculis dui hendrerit. Duis accumsan venenatis varius. Pellentesque eu urna nisl. Vestibulum id ligula ut tellus molestie vehicula pulvinar id turpis. Vivamus a mollis orci. Vivamus vulputate orci ac sem congue scelerisque molestie eu nunc. Ut varius lorem eu massa fringilla iaculis. Donec tristique dui non massa bibendum, id venenatis tellus suscipit. Maecenas vehicula, lacus id consectetur suscipit, lorem libero bibendum turpis, vel dignissim lectus sem eu augue.'
				]
			],
			[
				'lang' => 'fr',
				'data' => [
					'title' => 'Une marche à Forina',
					'content' => 'Description du contenu - Lorem ipsum dolor sit amet, consectetur adipiscing elit. In placerat, nibh et interdum faucibus, lorem nunc rhoncus neque, id efficitur ex urna a lorem. Suspendisse potenti. Praesent lorem lorem, semper a diam eu, dignissim mollis odio. Quisque consequat purus ut nibh pellentesque, eget iaculis dui hendrerit. Duis accumsan venenatis varius. Pellentesque eu urna nisl. Vestibulum id ligula ut tellus molestie vehicula pulvinar id turpis. Vivamus a mollis orci. Vivamus vulputate orci ac sem congue scelerisque molestie eu nunc. Ut varius lorem eu massa fringilla iaculis. Donec tristique dui non massa bibendum, id venenatis tellus suscipit. Maecenas vehicula, lacus id consectetur suscipit, lorem libero bibendum turpis, vel dignissim lectus sem eu augue.'
				]
			]
		],
		'partners' => [],
		'rates' => [
			[
				'data' => [ 'value' => 5 ],
				'userMail' => 'm.gavanier@gmail.com'
			]
		],
		'tags' => []
	],
	[
		'data' => [
			'duration_days' => 0,
			'duration_hours'=> 3,
			'duration_minutes' => 0,
			'min_persons' => 1,
			'max_persons' => 10,
			'incurred_cost' => 0,
			'incurred_transportation_cost' => 0,
			'incurred_food_drink_cost' => 0,
			'incurred_ticket_cost' => 0,
			'incurred_other_cost' => 0,
			'incurred_cost_per_person' => 0,
			'incurred_transportation_cost_per_person' => 0,
			'incurred_food_drink_cost_per_person' => 0,
			'incurred_ticket_cost_per_person' => 0,
			'incurred_other_cost_per_person' => 0,
			'suggested_tip' => 45,
			'is_experience_per_person' => false,
			'state' => 'ONLINE'
		],
		'language_aliases' => ['en', 'fr'],
		'area' => [
			'data' => [
				'range' => 100
			],
			'address' => [
				'street' => '73 rue Ferdinand Buisson',
				'zipcode' => '69003',
				'city' => 'Vermilion City',
				'country' => 'Kanto',
				'latitude' => 45.750065,
				'longitude' => 4.889845
			]
		],
		'meetingPoint' => [
			'street' => '142 Avenue Berthelot',
			'zipcode' => '69007',
			'city' => 'Vermilion City',
			'country' => 'Kanto',
			'latitude' => '45.742513',
			'longitude' => '4.849713'
		],
		'cover' => 'imgExperienceTest.jpg',
		'userMail' => 'nicolas.treiber@gmail.com',
		'descriptions' => [
			[
				'lang' => 'en',
				'data' => [
					'title' => 'A tour in Vermilion City',
					'content' => 'Content Description - Lorem ipsum dolor sit amet, consectetur adipiscing elit. In placerat, nibh et interdum faucibus, lorem nunc rhoncus neque, id efficitur ex urna a lorem. Suspendisse potenti. Praesent lorem lorem, semper a diam eu, dignissim mollis odio. Quisque consequat purus ut nibh pellentesque, eget iaculis dui hendrerit. Duis accumsan venenatis varius. Pellentesque eu urna nisl. Vestibulum id ligula ut tellus molestie vehicula pulvinar id turpis. Vivamus a mollis orci. Vivamus vulputate orci ac sem congue scelerisque molestie eu nunc. Ut varius lorem eu massa fringilla iaculis. Donec tristique dui non massa bibendum, id venenatis tellus suscipit. Maecenas vehicula, lacus id consectetur suscipit, lorem libero bibendum turpis, vel dignissim lectus sem eu augue.'
				]
			],
			[
				'lang' => 'fr',
				'data' => [
					'title' => 'Un tour de Carmin sur mer',
					'content' => 'Description du contenu - Lorem ipsum dolor sit amet, consectetur adipiscing elit. In placerat, nibh et interdum faucibus, lorem nunc rhoncus neque, id efficitur ex urna a lorem. Suspendisse potenti. Praesent lorem lorem, semper a diam eu, dignissim mollis odio. Quisque consequat purus ut nibh pellentesque, eget iaculis dui hendrerit. Duis accumsan venenatis varius. Pellentesque eu urna nisl. Vestibulum id ligula ut tellus molestie vehicula pulvinar id turpis. Vivamus a mollis orci. Vivamus vulputate orci ac sem congue scelerisque molestie eu nunc. Ut varius lorem eu massa fringilla iaculis. Donec tristique dui non massa bibendum, id venenatis tellus suscipit. Maecenas vehicula, lacus id consectetur suscipit, lorem libero bibendum turpis, vel dignissim lectus sem eu augue.'
				]
			]
		],
		'partners' => [],
		'rates' => [
			[
				'data' => [ 'value' => 4 ],
				'userMail' => 'm.gavanier@gmail.com'
			],
			[
				'data' => [ 'value' => 4 ],
				'userMail' => 'romain.cambonie@gmail.com'
			]
		],
		'tags' => [
			["name" => "beach"],
			["name" => "sea"],
			["name" => "fishing"],
			["name" => "boat ride"]
		]
	]
];