<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;


class Kernel extends HttpKernel
{
    /**
     * Les middleware globaux qui s'exécutent sur chaque requête.
     *
     * @var array
     */
    protected $middleware = [
        // Gestion des proxies
        \App\Http\Middleware\TrustProxies::class,
        
        // Gestion CORS (Cross-Origin Resource Sharing)
        //\Fruitcake\Cors\HandleCors::class,
        \Illuminate\Http\Middleware\HandleCors::class,

        
        // Empêcher les requêtes pendant la maintenance
        \App\Http\Middleware\PreventRequestsDuringMaintenance::class,
        
        // Validation de la taille max des requêtes POST
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        
        // Trim (suppression) des espaces en début et fin de chaînes dans les inputs
        \App\Http\Middleware\TrimStrings::class,
        
        // Conversion des chaînes vides en null
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * Middleware de groupe (web, api).
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            // Gestion des cookies encryptés
            \App\Http\Middleware\EncryptCookies::class,
            
            // Ajout des cookies aux réponses
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            
            // Gestion de session
            \Illuminate\Session\Middleware\StartSession::class,
            
            // Partage des erreurs de validation dans la session
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            
            // Protection CSRF
            \App\Http\Middleware\VerifyCsrfToken::class,
            
            // Liaison des routes et modèles
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            // Limitation de fréquence (rate limiting)
            'throttle:api',
            
            // Liaison des routes et modèles
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * Middleware assignables individuellement sur les routes.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,

        'isAdmin' => \App\Http\Middleware\IsAdmin::class,

        
        // Si tu as un middleware admin, tu peux l’ajouter ici :
        // 'adminMiddleware' => \App\Http\Middleware\AdminMiddleware::class,
    ];
}
