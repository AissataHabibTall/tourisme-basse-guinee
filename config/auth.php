<?php

return [

    /*
    |---------------------------------------------------------------------------
    | Authentication Defaults
    |---------------------------------------------------------------------------
    |
    | Cette option définit le "guard" d'authentification par défaut et le 
    | "broker" de réinitialisation de mot de passe pour votre application.
    | Vous pouvez changer ces valeurs si nécessaire, mais elles sont parfaites
    | pour la plupart des applications.
    |
    */

    'defaults' => [
        'guard' => env('AUTH_GUARD', 'web'),
        'passwords' => env('AUTH_PASSWORD_BROKER', 'utilisateurs'),
    ],

    /*
    |---------------------------------------------------------------------------
    | Authentication Guards
    |---------------------------------------------------------------------------
    |
    | Ensuite, vous pouvez définir chaque "guard" d'authentification pour 
    | votre application. Un "guard" définit comment un utilisateur est 
    | authentifié pour chaque requête.
    |
    | Le "web" guard utilise la session et le provider d'utilisateur Eloquent.
    |
    | Supported: "session"
    |
    */

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'utilisateurs',
        ],
    ],

    /*
    |---------------------------------------------------------------------------
    | User Providers
    |---------------------------------------------------------------------------
    |
    | Chaque "guard" d'authentification a un "provider" d'utilisateur, qui
    | définit comment les utilisateurs sont récupérés depuis la base de données
    | ou un autre système de stockage.
    |
    | Vous devez configurer le provider pour utiliser le modèle `Utilisateur`.
    |
    | Supported: "eloquent", "database"
    |
    */

    'providers' => [
        'utilisateurs' => [
            'driver' => 'eloquent',
            'model' => App\Models\Utilisateur::class,
        ],
    ],

    /*
    |---------------------------------------------------------------------------
    | Resetting Passwords
    |---------------------------------------------------------------------------
    |
    | Ces options spécifient le comportement de la fonctionnalité de réinitialisation
    | du mot de passe de Laravel, y compris la table utilisée pour le stockage des
    | tokens de réinitialisation et le provider utilisateur.
    |
    */

    'passwords' => [
        'utilisateurs' => [
            'provider' => 'utilisateurs',
            'table' => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_reset_tokens'),
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    /*
    |---------------------------------------------------------------------------
    | Password Confirmation Timeout
    |---------------------------------------------------------------------------
    |
    | Cette option définit le délai d'expiration pour la confirmation du mot de
    | passe avant qu'un utilisateur ne soit invité à saisir à nouveau son mot
    | de passe via l'écran de confirmation.
    |
    | Par défaut, ce délai dure 3 heures.
    |
    */

    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),

];
