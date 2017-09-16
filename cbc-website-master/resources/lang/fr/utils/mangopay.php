<?php
/**
 * Created by PhpStorm.
 * User: Romain
 * Date: 10/07/2015
 * Time: 14:38
 */

return [
    'errors' => [
        'registration' =>'The payment transaction failed at the registration step.',
        'preregistration' =>'The payment transaction failed at the card registration step.',
        'editregistration' =>'The payment transaction failed at the card registration validation step.',
        'preauthorisation' =>'The payment transaction failed at the card payment pre-authorization step.',
        'createupdatewallet' => 'The mangopay wallet creation or edition has failed',
        'createupdatebank' =>'The mangopay bank account creation or edition has failed',
    ],
    'suggestions' => [
        'registration' =>'Please verify that the card informations you entered are correct',
        'preregistration' =>'Please verify that the card informations you entered are correct',
        'editregistration' =>'Please verify that the card informations you entered are correct',
        'preauthorisation' =>'Please verify that you have the required funds in your account',
        'createupdatewallet' => 'The mangopay wallet creation or please verify that your ',
        'createupdatebank' =>'The mangopay bank account creation or edition has failed',
    ],
    'titles' => [
        'error' => 'Transaction error'
    ],
];