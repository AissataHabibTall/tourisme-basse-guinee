<x-app-layout> 
    <x-slot name="header">
        <h2 class="text-3xl font-bold text-gray-800 dark:text-white leading-tight text-center">
            À propos du projet
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl rounded-lg">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-8">
                    <!-- Image principale -->
                    <div>
                        <img src="https://images.unsplash.com/photo-1517430816045-df4b7de11d1d?auto=format&fit=crop&w=800&q=80" 
                             alt="Culture et tradition en Guinée"
                             class="w-full h-96 object-cover rounded-lg shadow-md">
                    </div>

                    <!-- Texte d'introduction -->
                    <div class="flex flex-col justify-center">
                        <h3 class="text-2xl font-bold text-gray-800 dark:text-white mb-4">Présentation du projet</h3>
                        <p class="text-gray-700 dark:text-gray-300 text-lg mb-4 leading-relaxed">
                            Ce site a été réalisé dans le cadre du Projet de Fin d’Études pour l’obtention du diplôme d’Ingénieur d’État
                            en Génie Informatique à l’Université Kofi Annan de Guinée.
                        </p>
                        <p class="text-gray-700 dark:text-gray-300 text-lg leading-relaxed">
                            L’objectif principal est de valoriser le potentiel touristique de la Basse-Guinée à travers une application web
                            moderne, sécurisée et facile d’utilisation, permettant aux utilisateurs de découvrir des lieux, réserver des guides,
                            des hébergements, ou encore consulter les événements de la région.
                        </p>
                    </div>
                </div>

                <!-- Technologies -->
                <div class="px-8 pb-6">
                    <div class="mt-10">
                        <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-4 text-center">
                            Technologies et outils utilisés
                        </h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                            <div class="bg-white dark:bg-gray-700 p-4 rounded-lg shadow text-center">
                                <i class="fab fa-laravel fa-2x text-red-600"></i>
                                <h4 class="text-lg font-semibold text-gray-800 dark:text-white">Laravel & PHP</h4>
                                <p class="text-gray-600 dark:text-gray-300 text-sm mt-2">
                                    Développement backend, architecture MVC et sécurité.
                                </p>
                            </div>
                            <div class="bg-white dark:bg-gray-700 p-4 rounded-lg shadow text-center">
                                <i class="fas fa-database fa-2x text-blue-600"></i>
                                <h4 class="text-lg font-semibold text-gray-800 dark:text-white">MySQL</h4>
                                <p class="text-gray-600 dark:text-gray-300 text-sm mt-2">
                                    Base de données relationnelle pour stocker lieux, guides, utilisateurs, réservations…
                                </p>
                            </div>
                            <div class="bg-white dark:bg-gray-700 p-4 rounded-lg shadow text-center">
                                <!-- Icône SVG officielle Tailwind -->
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" class="mx-auto w-10 h-10">
                                    <path fill="#38bdf8" d="M24 9c-6 0-9.75 3-11.25 9 2.25-3 4.875-4.125 7.875-3.375 
                                        1.711.427 2.935 1.674 4.286 3.04C26.63 19.2 28.562 21 32.25 21c6 0 9.75-3 11.25-9-2.25 3-4.875 4.125-7.875 
                                        3.375-1.711-.427-2.935-1.674-4.286-3.04C29.87 10.8 27.938 9 24 9zm-11.25 
                                        12C7 21 3.25 24 1.75 30c2.25-3 4.875-4.125 7.875-3.375 1.711.427 2.935 1.674 
                                        4.286 3.04C15.63 31.2 17.562 33 21.25 33c6 0 9.75-3 11.25-9-2.25 3-4.875 
                                        4.125-7.875 3.375-1.711-.427-2.935-1.674-4.286-3.04C20.87 22.8 18.938 21 15 
                                        21z"/>
                                </svg>
                                <h4 class="text-lg font-semibold text-gray-800 dark:text-white">Tailwind CSS</h4>
                                <p class="text-gray-600 dark:text-gray-300 text-sm mt-2">
                                    Interface moderne et responsive côté frontend.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Notre mission -->
                <div class="px-8 pb-6">
                    <div class="mt-10 text-center">
                        <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Notre objectif</h3>
                        <p class="text-gray-700 dark:text-gray-300 text-md max-w-3xl mx-auto leading-relaxed">
                            Mettre à disposition une plateforme innovante pour soutenir le tourisme local et offrir aux visiteurs des outils
                            fiables pour planifier leur séjour, dans une démarche de digitalisation du patrimoine national.
                        </p>
                    </div>
                </div>

                <!-- Fonctionnalités -->
                <div class="mt-10 px-8 pb-6">
                    <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-6 text-center">
                        Fonctionnalités principales
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                        <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow text-center">
                            <i class="fas fa-map-marker-alt fa-2x text-danger"></i>
                            <h4 class="text-lg font-semibold text-gray-800 dark:text-white">Découvrir les lieux</h4>
                            <p class="text-gray-600 dark:text-gray-300 text-sm mt-2">
                                Listing filtrable de sites naturels, historiques et culturels.
                            </p>
                        </div>
                        <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow text-center">
                            <i class="fas fa-user-tie fa-2x text-success"></i>
                            <h4 class="text-lg font-semibold text-gray-800 dark:text-white">Réserver des guides</h4>
                            <p class="text-gray-600 dark:text-gray-300 text-sm mt-2">
                                Mise en relation avec des guides touristiques certifiés.
                            </p>
                        </div>
                        <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow text-center">
                            <i class="fas fa-bed fa-2x text-info"></i>
                            <h4 class="text-lg font-semibold text-gray-800 dark:text-white">Hébergements</h4>
                            <p class="text-gray-600 dark:text-gray-300 text-sm mt-2">
                                Réservations de logements adaptés aux besoins des visiteurs.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Pourquoi ce projet est fiable -->
                <div class="px-8 pb-12">
                    <div class="mt-10 text-center">
                        <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">
                            Fiabilité et qualité du projet
                        </h3>
                        <p class="text-gray-700 dark:text-gray-300 text-md max-w-4xl mx-auto leading-relaxed">
                            Ce projet a été conçu avec un souci de qualité académique, en suivant les bonnes pratiques de développement (ORM Eloquent, validation, middleware).
                            Il a été testé et documenté pour garantir une utilisation fluide. Le système est évolutif et pourra intégrer de nouvelles fonctionnalités telles que les
                            paiements en ligne ou une API mobile dans l’avenir.
                        </p>
                    </div>

                    <!-- Méthodologie et auteur -->
                    <div class="mt-5 p-4 text-center rounded">
                        <h4>Auteur du projet</h4>
                        <p>AISSATA HABIB TALL – Matricule IN20 161</p>
                        <h4>Encadrant</h4>
                        <p>M. Damang Lanciné Saran</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
