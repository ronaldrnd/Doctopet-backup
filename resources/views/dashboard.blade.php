@include("includes.header")

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | {{ env("APP_NAME") }}</title>
    @vite('resources/css/app.css')
</head>

<div class="flex">
    <livewire:dashboard-component />

    <div class="min-h-screen bg-gray-100 w-fill-available">
        <div class="container mx-auto py-10 px-4">
            <!-- Welcome Section -->
            <div class="bg-white shadow-lg rounded-lg p-6 mb-8">
                <h1 class="text-3xl font-bold text-green-700">
                    Bienvenue
                    <span class="text-green-800 font-extrabold">
                        {{ Auth::user()->name }}

                    </span>
                    sur votre tableau de bord
                </h1>
                <p class="text-gray-600 mt-2">
                    Gérez vos animaux, prenez des rendez-vous et accédez à vos informations en toute simplicité.
                </p>
            </div>


            @php
                $user = \Illuminate\Support\Facades\Auth::user();
                $subscription = $user->subscriptions()
                ->where('stripe_status', 'active')
                ->orWhere('stripe_status','trialing')
                ->first();
                $plan = null;
                $isAmbassador = $user->is_ambassador;
                $isOnTrial = $user->hasActiveTrial();
                $trialEndDate = $user->free_trial_end ? \Carbon\Carbon::parse($user->free_trial_end) : null;

                if ($subscription) {
                    $plan = \App\Models\Plan::where('stripe_plan', $subscription->stripe_price)->first();
                }
            @endphp

            @if($user->type == "S")

                <div class="bg-white shadow-md rounded-lg p-6 mb-6 text-gray-700">

                    @if($isAmbassador)
                        <!-- ✅ Utilisateur Ambassadeur -->
                        <p class="text-green-600 font-semibold flex items-center">
                            🌟 Félicitations ! Vous êtes un ambassadeur Doctopet !
                        </p>
                        <p class="text-gray-600 mt-2">
                            En tant qu'ambassadeur, votre abonnement est garanti <strong>à vie</strong> 🎉. Merci pour votre soutien et votre contribution à la communauté Doctopet !
                        </p>
                        <a href="{{ route('subscription.index') }}" class="mt-4 inline-block bg-green-600 hover:bg-green-700 text-white font-semibold px-5 py-2 rounded-md transition-all">
                            ⚙️ Gérer mon compte
                        </a>

                    @elseif($isOnTrial)
                        <!-- 🔥 Utilisateur en période d'essai -->
                        <p class="text-blue-600 font-semibold flex items-center">
                            🎁 Vous êtes en période d'essai !
                        </p>
                        <p class="text-gray-600 mt-2">
                            Votre abonnement est actif et vous profitez de toutes les fonctionnalités gratuitement jusqu'au <strong>{{ $trialEndDate->format('d/m/Y') }}</strong>.
                            N'oubliez pas de souscrire à un abonnement avant la fin de l'essai pour continuer à utiliser Doctopet sans interruption !
                        </p>
                        <a href="{{ route('subscription.index') }}" class="mt-4 inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2 rounded-md transition-all">
                            ⚙️ Gérer mon abonnement
                        </a>

                    @elseif($plan)
                        <!-- ✅ Utilisateur avec un abonnement classique -->
                        <p class="text-green-600 font-semibold flex items-center">
                            ✅ Votre abonnement actuel : <span class="ml-2 text-xl font-bold">{{ $plan->name }}</span>
                        </p>
                        <p class="text-gray-600 mt-2">
                            Vous bénéficiez de tous les avantages liés à votre abonnement. Gérez votre compte via le bouton ci-dessous.
                        </p>
                        <a href="{{ route('subscription.index') }}" class="mt-4 inline-block bg-green-600 hover:bg-green-700 text-white font-semibold px-5 py-2 rounded-md transition-all">
                            ⚙️ Gérer mon abonnement
                        </a>

                    @else
                        <!-- ❌ Utilisateur sans abonnement -->
                        <p class="text-red-600 font-semibold flex items-center">
                            ⚠️ Votre compte n'est pas encore activé !
                        </p>
                        <p class="text-gray-600 mt-2">
                            Pour bénéficier de toutes les fonctionnalités, souscrivez à un abonnement dès maintenant.
                        </p>

                        <div class="flex justify-center gap-4 mt-4">
                            <a href="{{ route('about.subscription') }}"
                               class="text-white bg-blue-600 hover:bg-blue-700 hover:underline px-5 py-2 rounded-md transition-all shadow-md">
                                ℹ️ En savoir plus
                            </a>

                            <a href="{{ route('subscription.index') }}"
                               class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold px-5 py-2 rounded-md transition-all shadow-md">
                                📜 Souscrire à un abonnement
                            </a>
                        </div>

                    @endif

                </div>
            @endif






            <!-- ✅ Boutons d'accès rapide (2x2 Grid) -->
            <div class="grid grid-cols-2 gap-6 ">
                <!-- Profil -->
                <a href="{{ route('profil', Auth::id()) }}" class="bg-white shadow-md rounded-lg p-6 flex flex-col items-center transition hover:shadow-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 w-10 text-green-600 mr-1">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                    <span class="text-lg font-semibold text-gray-800">Vos informations</span>
                </a>


                <!-- Rendez-vous -->
                <a href="{{ $user->type == "C" ? route('appointments.overview') : route("appointments.calendar") }}" class="bg-white shadow-md rounded-lg p-6 flex flex-col items-center transition hover:shadow-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 w-10 text-green-600 mr-3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                    </svg>
                    <span class="text-lg font-semibold text-gray-800">{{$user->type == "C" ? "Vos Rendez-vous" : "Votre Agenda"}}</span>
                </a>


                <!-- Messages -->
                <a href="{{ $user->type == "C" ? route("conversations.overview") : route("conversations.pro.to.client") }}" class="bg-white shadow-md rounded-lg p-6 flex flex-col items-center transition hover:shadow-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 w-10 text-green-600 mr-3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                    </svg>
                    <span class="text-lg font-semibold text-gray-800">Vos Messages</span>
                </a>

                <!-- Documents -->
                <a href="{{route("client.documents")}}"  class="bg-white shadow-md rounded-lg p-6 flex flex-col items-center transition hover:shadow-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 w-10 text-green-600 mr-3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m.75 12 3 3m0 0 3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                    </svg>
                    <span class="text-lg font-semibold text-gray-800">Mes Documents</span>
                </a>
            </div>
        </div>
    </div>
</div>

@include("includes.footer")
