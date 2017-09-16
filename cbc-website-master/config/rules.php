<?php return [
    'AccountCreation' => [
    'firstname' => 'required',
    'lastname' => 'required',
    'mail' => 'required|email|unique:accounts,mail',
    'password' => 'required|confirmed'
    ],
    'Profile' => [
      'firstname' => 'required',
      'lastname' => 'required',
      'gender' => 'numeric',
      'date.day' => 'numeric|between:1,31',
      'date.month' => 'numeric|between:1,12',
      'date.year' => 'numeric',
      'nationality' => 'string|size:2',
      'phone' => 'numeric'
    ],
    'Address' => [
    'street' => 'string|min:1',
    'zipcode' => 'numeric|min:4',
    'city' => 'string|min:1',
    'country' => 'string|min:2',
    'latitude' => 'numeric',
    'longitude' => 'numeric'
    ],
    'Bank' => [
    'iban' => ['required', 'regex:/^[a-z]{2}\d{2} *([a-z\d] *){0,30}$/i'],
    'bic' => 'required | regex:/^[a-z]{6}[a-z\d]{2}([a-z\d]{3})?$/i',
    ],
    'Payment' =>  [
      'cardNumber' => 'required|credit_card',
      'cardExpirationDate' => 'required|expiration_date',
      'cardCvx' => 'required|between:3,4'
    ],
    'Experience' => [
      'duration' => 'required|numeric|min:15',
      'min_persons' => 'required|numeric|min:1|less_than:max_persons',
      'max_persons' => 'required|numeric|min:1|more_than:min_persons',
      'costs.tips.value' => 'numeric|min:1|required',
      'costs.food.value' => 'numeric|min:0',
      'costs.transportation.value' => 'numeric|min:0',
      'costs.ticket.value' => 'numeric|min:0',
      'costs.other.value' => 'numeric|min:0',
    ],
    'Area' => [
      'first-city' => 'required|string|min:2',
      'country' => 'required|string|min:2',
      'distance' => 'required|numeric|min:0.5'
    ],
    'ExperienceAddress' => [
      'street' => 'required|string|min:2',
      'zipcode' => 'numeric|min:4',
      'city' => 'required|string|min:2',
      'country' => 'required|string|min:2'
    ],
    'ExperienceDescription' => [
      'title' => 'required|string|min:5',
      'content' => 'required|string|min:10'
    ],
    'Image' => [
        'data' => 'image64|size64:10000'
    ],
    'Tag' => [
        'tags' => 'string_array'
    ]
];