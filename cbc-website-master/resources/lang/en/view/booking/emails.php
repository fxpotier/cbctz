<?php
/**
 * Created by PhpStorm.
 * User: Romain
 * Date: 14/07/2015
 * Time: 17:06
 */
return [
    'subject' => [
        'citizen' => [
            'auto' => 'New automatic reservation',
            'asked' => 'New reservation demand',
            'booked' => 'Reservation confirmed',
            'denied' => 'Reservation rejected',
            'canceled' => 'The reservation has been cancelled',
            'reminder' => 'Reminder for your experience tomorrow',
            'done' => 'Experience feedback'
        ],
        'traveler' => [
            'auto' => 'New automatic reservation',
            'asked' => 'Your reservation demand has been saved',
            'booked' => 'Your reservation demand has been accepted',
            'denied' => 'Your reservation demand has been denied',
            'canceled' => 'You cancelled your reservation',
            'reminder' => 'Reminder for your experience tomorrow',
            'done' => 'Experience feedback'
        ]
    ],
    'content' => [
        'common' => [
            'contact' => 'Contact information :',
            'mail' => 'email : :email',
            'phone' => 'phone : :phone',
            'feedback' => 'We love to hear feedback from you. Do no hesitate to give us your thoughts and impressions on ',
            'bookings' => 'Go to my bookings',
        ],
        'citizen' => [
            'common' => [
                'contact' => 'You may already contact :traveler to organise your meeting.',
            ],
            'auto' => [
                'reservation' => 'You received a new reservation for :experience on the :date at :time by :traveler',
            ],
            'asked' => [
                'reservation' => 'You received a new reservation demand for :experience on the :date at :time',
                'confirm' => 'You may accept or decline this demand by clicking on the following link :',
            ],
            'booked' => [
                'confirm' => 'You accepted the reservation demand for :experience on the :date at :time with :traveler',
            ],
            'denied' => [
                'deny' => 'You denied the reservation demand for :experience on the :date at :time with :traveler',
                'agenda' => 'Do not hesitate to complete the reservation calendar to receive less reservation demands that do not suit you.'
            ],
            'canceled' => [
                'cancel' => 'Unfortunately, :traveler cancelled :experience on the :date at :time.',
                'info' => 'As a reminder, if the experience is canceled less than 24 hours from the start you will receive all the costs incured.'
            ],
            'reminder' => [
                'remind' => 'Tomorrow you will meet :traveler at :time for :experience',
                'contact' => 'If it is not already done, contact :traveler as soon as possible to plan your meeting.',
                'tip' =>  'At the end of the experience, if :traveler forget, do not hesitate to recall that the tips are the only Citizens income .',
            ],
            'feedback' => [
                'start' => 'We hope that you have had a good time during :experience with :traveler',
                'feedback' => 'It would be awesome if you could share your experience by giving a comment on :traveler',
            ],
        ],
        'traveler' => [
            'common' => [
                'reservation' => 'Your reservation demand for :experience on the :date at :time with :citizen',
                'contact' => ':citizen will contact you soon to plan your meeting.',
                'tip' => 'After the experience, do not forget to tip. Tips are the only income of the Citizens. Please give à minimum of 1€ considering your satisfaction and the suggestion indicated by the Citizen. If you spend an exceptional moment, nothing stops you from giving him more. ',
                'payment' => 'We confirm the preauthorisation for a payment of :price € relative to the booking of this experience.'
            ],
            'auto' => ' has been validated.',
            'asked' => [
                'reservation' => ' has been saved.',
                'info' => 'Your reservation is waiting to be validated by :citizen. In case of deny all the experience and reservation costs will be either not charged or refunded',
            ],
            'booked' =>':citizen has accepted your reservation demand for :experience on the :date at :time',
            'denied' => [
                'deny' => ' has been denied by the Citizen.',
                'refund' => 'All the experience and reservation costs will be either not charged or refunded.',
                'info' => 'Do not hesitate to ask for another experience on CitybyCitizen.com.'
            ],
            'canceled' => [
                'cancel' => 'You have canceled the experience :experience on the :date at :time with :citizen.',
                'info' => 'As a reminder, if the experience is canceled less than 48 hours from the start you will be charged the booking costs. Less than 24h from the start the incured costs are added.'
            ],
            'reminder' => [
                'remind' => 'Tomorrow you will meet :citizen at :time for :experience',
                'contact' => 'If it is not already done, contact :citizen do not hesitate to call or send an email to plan your meeting.',
            ],
            'feedback' => [
                'start' => 'We hope that you have had a good time during :experience with :citizen',
                'feedback' => 'It would be awesome if you could share your experience by giving a comment on :citizen\'s :experience',
            ]
        ]

    ]
];