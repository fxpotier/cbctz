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
            'auto' => 'Nouvelle réservation automatique',
            'asked' => 'Nouvelle demande de réservation',
            'booked' => 'Réservation confirmée',
            'denied' => 'Réservation refusée',
            'canceled' => 'Réservation annulée',
            'reminder' => 'Rappel: votre expérience de demain',
            'done' => 'Retour d\'Expérience'
        ],
        'traveler' => [
            'auto' => 'Nouvelle réservation',
            'asked' => 'Votre réservation a été enregistrée',
            'booked' => 'Votre réservation a été acceptée',
            'denied' => 'Votre réservation a été déclinée',
            'canceled' => 'Votre réservation a été annulée',
            'reminder' => 'Rappel: votre expérience de demain',
            'done' => 'Retour d\'Expérience'
        ]
    ],
    'content' => [
        'common' => [
            'contact' => 'Informations de contact :',
            'mail' => 'email : :email',
            'phone' => 'téléphone : :phone',
            'feedback' => 'On adore recevoir vos feedbacks. N\'hésitez pas à nous faire part de vos retours à  ',
            'bookings' => 'Voir mes réservations',
        ],
        'citizen' => [
            'common' => [
                'contact' => 'Vous pouvez déjà contacter :traveler pour organiser votre rendez-vous.',
            ],
            'auto' => [
                'reservation' => 'Vous avez reçu une nouvelle réservation pour :experience le :date à :time par :traveler',
            ],
            'asked' => [
                'reservation' => 'Vous avez reçu une nouvelle réservation pour :experience le :date à :time',
                'confirm' => 'Vous pouvez accepter ou refuser cette demande en cliquant sur le lien suivant :',
            ],
            'booked' => [
                'confirm' => 'Vous avez accepté une demande de réservation pour :experience le :date à :time avec :traveler',
            ],
            'denied' => [
                'deny' => 'Vous avez refusé la demande de réservation pour :experience le :date à :time avec :traveler',
                'agenda' => 'N\'hésitez pas à compléter le calendrier de vos disponibilités pour recevoir moins de demandes ne vous convenant pas.'
            ],
            'canceled' => [
                'cancel' => 'Malheureusement, :traveler a annulé la réservation pour :experience le :date à :time.',
                'info' => 'N\'oubliez pas que si la réservation est annulée moins de 24h avant le début de l\'expérience, vous recevez les frais engagés.'
            ],
            'reminder' => [
                'remind' => 'Demain, vous rencontrer :traveler à :time pour :experience',
                'contact' => 'Si ce n\'est pas fait, contactez :traveler dès que possible pour arranger votre rendez-vous.',
                'tip' =>  'A la fin de l\'expérience, si :traveler oublie, n\'hésitez pas à lui rappeler gentillement que les pourboires sont les seuls bénéfices des Citizens .',
            ],
            'feedback' => [
                'start' => 'Nous espérons que vous avez passé un bon moment pendant :experience avec :traveler',
                'feedback' => 'Ce serait génial si vous partagiez votre expérience en laissant un commentaire à :traveler',
            ],
        ],
        'traveler' => [
            'common' => [
                'reservation' => 'Votre demande de réservation pour :experience le :date à :time avec :citizen',
                'contact' => ':citizen va vous contacter rapidement pour organiser votre rendez-vous.',
                'tip' => 'Après l\'expérience, n\'oublier pas de donner un pourboire. Les pourboires sont les seuls bénéfices financiers des Citizens. Donner au moins 1€ en fonction de votre satisfaction et du montant suggéré par le Citizen.<br> Si vous passez un super moment, rien ne vous empêche de donner plus ',
                'payment' => 'Nous vous confirmons la préautorisation de votre paiement d\'une valeur de :price €  pour la réservation de cette expérience.'
            ],
            'auto' => ' a été validée.',
            'asked' => [
                'reservation' => ' a été enregistrée.',
                'info' => 'Votre réservation est en attente de validation par :citizen. En cas de refus, vous serez intégralement remboursés.',

            ],
            'booked' =>':citizen a accepté votre demande de réservation pour :experience le :date à :time',
            'denied' => [
                'deny' => ' a été refusée par le Citizen.',
                'refund' => 'Vous serez évidement intégralement remboursés',
                'info' => 'N\'hésitez pas à réserver une autre expérience sur CitybyCitizen.com.'
            ],
            'canceled' => [
                'cancel' => 'Vous avez annulé l\'expérience :experience le :date à :time avec :citizen.',
                'info' => 'Nous vous rappelons que si vous annuler une réservation moins de 48 heures avant le début de l\'expérience vous ne serez pas remboursés des frais de réservation. Moins de 24 heures avant, tous les frais vous serez facturés.'
            ],
            'reminder' => [
                'remind' => 'Demain, vous rencontrer :citizen à :time pour :experience',
                'contact' => 'Si :citizen ne vous a pas encore contacté, n\'hésitez pas à le contacter pour organiser votre rendez-vous.',
            ],
            'feedback' => [
                'start' => 'Nous espérons que vous avez passé un bon moment pendant :experience avec :citizen',
                'feedback' => 'Ce serait génial si vous partagiez votre expérience avec :citizen pour :experience en laissant un commentaire!',
            ]
        ]

    ]
];