<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ config('app.name', 'Tourisme Guinée') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />

    <style>
        .flag-animate {
            display: inline-block;
            animation: wave 2s infinite;
            transform-origin: 70% 70%;
            vertical-align: middle;
        }

        @keyframes wave {
            0%, 100% { transform: rotate(0deg); }
            25% { transform: rotate(5deg); }
            50% { transform: rotate(-5deg); }
            75% { transform: rotate(5deg); }
        }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-r from-blue-50 via-white to-green-50 dark:from-gray-900 dark:to-gray-800 font-sans antialiased">

    <div class="min-h-screen flex flex-col items-center justify-center text-center px-4 py-8 relative">

        @auth
            <div class="absolute top-4 right-4 flex gap-2">
                <a href="{{ route('profile.edit') }}"
                   class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-md transition duration-300">
                    Voir Profil
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="bg-red-600 hover:bg-red-700 text-white font-semibold px-4 py-2 rounded-md transition duration-300">
                        Déconnexion
                    </button>
                </form>
            </div>
        @endauth

        <h1 class="text-5xl font-extrabold text-blue-800 dark:text-white mb-6 flex items-center justify-center gap-3">
            Bienvenue sur
            <span class="text-green-600 font-extrabold flex items-center gap-2">
                Tourisme Guinée
                <img src="https://upload.wikimedia.org/wikipedia/commons/e/ed/Flag_of_Guinea.svg"
                     alt="Drapeau de la Guinée"
                     class="flag-animate w-10 h-auto rounded-sm shadow-sm" />
            </span>
        </h1>

        @guest
            <p class="text-gray-700 dark:text-gray-300 max-w-md mx-auto mb-4">
                Veuillez vous connecter ou vous inscrire pour accéder à toutes les fonctionnalités.
            </p>

            <div class="flex justify-center gap-4 mb-6">
                <a href="{{ route('login') }}"
                   class="bg-blue-700 hover:bg-blue-800 text-white font-semibold px-6 py-2 rounded-md transition">
                    Se connecter
                </a>
                <a href="{{ route('register') }}"
                   class="bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-2 rounded-md transition">
                    S'inscrire
                </a>
            </div>
        @endguest

        @auth
            <div class="w-full max-w-4xl grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                <a href="{{ route('lieux.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-4 rounded-xl shadow-lg transition flex flex-col items-center justify-center gap-2 text-center min-h-[180px]">
                    <i class="fas fa-map-marker-alt text-4xl"></i>
                    <h3 class="text-xl font-semibold">Voir les lieux touristiques</h3>
                    <p class="text-sm">Découvrez les plus beaux lieux de Guinée à visiter.</p>
                </a>

                <a href="{{ route('events.index') }}" class="bg-green-600 hover:bg-green-700 text-white px-6 py-4 rounded-xl shadow-lg transition flex flex-col items-center justify-center gap-2 text-center min-h-[180px]">
                    <i class="fas fa-calendar-alt text-4xl"></i>
                    <h3 class="text-xl font-semibold">Voir les évènements</h3>
                    <p class="text-sm">Ne manquez pas les événements importants autour de la Guinée.</p>
                </a>

                <a href="{{ route('restaurants.index') }}" class="bg-red-500 hover:bg-red-600 text-white px-6 py-4 rounded-xl shadow-lg transition flex flex-col items-center justify-center gap-2 text-center min-h-[180px]">
                    <i class="fas fa-utensils text-4xl"></i>
                    <h3 class="text-xl font-semibold">Voir les restaurants</h3>
                    <p class="text-sm">Découvrez les meilleures options gastronomiques de la Guinée.</p>
                </a>

                <a href="{{ route('guides.index') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-4 rounded-xl shadow-lg transition flex flex-col items-center justify-center gap-2 text-center min-h-[180px]">
                    <i class="fas fa-user-tie text-4xl"></i>
                    <h3 class="text-xl font-semibold">Voir les guides touristiques</h3>
                    <p class="text-sm">Trouvez les meilleurs guides pour vous accompagner.</p>
                </a>

                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.utilisateurs.index') }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-4 rounded-xl shadow-lg transition flex flex-col items-center justify-center gap-2 text-center min-h-[180px]">
                        <i class="fas fa-users text-4xl"></i>
                        <h3 class="text-xl font-semibold">Gestion des utilisateurs</h3>
                        <p class="text-sm">Gérez les utilisateurs inscrits sur la plateforme.</p>
                    </a>
                @endif

                <a href="{{ route('hebergements.index') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-4 rounded-xl shadow-lg transition flex flex-col items-center justify-center gap-2 text-center min-h-[180px]">
                    <i class="fas fa-bed text-4xl"></i>
                    <h3 class="text-xl font-semibold">Voir les hébergements</h3>
                    <p class="text-sm">Réservez un hébergement pour votre séjour en Guinée.</p>
                </a>

                @auth
    @can('viewAll', App\Models\Reservation::class)
        <a href="{{ route('admin.reservations.index') }}">
            <div class="bg-teal-600 hover:bg-teal-700 text-white px-6 py-4 rounded-xl shadow-lg transition flex flex-col items-center justify-center gap-2 text-center min-h-[180px]">
                <i class="fas fa-book text-4xl"></i>
                <h3 class="text-xl font-semibold">Voir les réservations</h3>
                <p class="text-sm">Gérez toutes les réservations.</p>
            </div>
        </a>
    @else
        <a href="{{ route('reservations.index') }}">
            <div class="bg-teal-600 hover:bg-teal-700 text-white px-6 py-4 rounded-xl shadow-lg transition flex flex-col items-center justify-center gap-2 text-center min-h-[180px]">
                <i class="fas fa-book text-4xl"></i>
                <h3 class="text-xl font-semibold">Voir les réservations</h3>
                <p class="text-sm">Consultez vos réservations.</p>
            </div>
        </a>
    @endcan
@endauth


                <!--@if(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.avis.index') }}" class="bg-orange-600 hover:bg-orange-700 text-white px-6 py-4 rounded-xl shadow-lg transition flex flex-col items-center justify-center gap-2 text-center min-h-[180px]">
                        <i class="fas fa-star text-4xl"></i>
                        <h3 class="text-xl font-semibold">Voir les avis</h3>
                        <p class="text-sm">Lisez les avis et commentaires sur différents services.</p>
                    </a>
                @endif -->

                <!--@if(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.circuits.index') }}" class="bg-pink-600 hover:bg-pink-700 text-white px-6 py-4 rounded-xl shadow-lg transition flex flex-col items-center justify-center gap-2 text-center min-h-[180px]">
                        <i class="fas fa-route text-4xl"></i>
                        <h3 class="text-xl font-semibold">Voir les circuits touristiques</h3>
                        <p class="text-sm">Explorez des circuits pour découvrir la Guinée autrement.</p>
                    </a>
                @endif -->

               @if(Auth::user()->role === 'admin')
    <a href="{{ route('admin.dashboard') }}" class="bg-cyan-600 hover:bg-cyan-700 text-white px-6 py-4 rounded-xl shadow-lg transition flex flex-col items-center justify-center gap-2 text-center min-h-[180px]">
        <i class="fas fa-tachometer-alt text-4xl"></i>
        <h3 class="text-xl font-semibold">Statistique Admin</h3>
        <p class="text-sm">Accédez à toutes les fonctionnalités d’administration.</p>
    </a>
@endif

@if(Auth::user()->role === 'admin')
<a href="{{ route('a-propos') }}" class="bg-slate-600 hover:bg-slate-700 text-white px-6 py-4 rounded-xl shadow-md transition flex flex-col items-center justify-center gap-2 text-center min-h-[180px]">
    <i class="fas fa-info-circle text-4xl"></i>
    <h3 class="text-xl font-semibold">PFE</h3>
    <p class="text-sm">Réaliser par Aissata Habib Tall</p>
</a>
@endif







            </div>
        @endauth

    </div>

</body>
</html>
