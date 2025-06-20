<div class="container mx-auto bg-gray-100 py-10 px-4">
    <h1 class="text-4xl font-bold text-green-700 mb-6">DOUTE CONCERNANT VOTRE COMPAGNON</h1>
    <p class="text-gray-600 italic mb-6">
        Notre conseiller est là pour vous indiquer les meilleures mesures à prendre,<span class=" font-extrabold "> en aucun cas il agit comme un professionnel de santé</span>, il est seulement mis à disposition pour vous donner des conseils.
    </p>

    <!-- Sélection de l'animal -->
    @if(Auth::check() && count($animals) > 0)
        <div class="mb-6">
            <label for="animal" class="block text-lg font-medium text-gray-700">Sélectionnez votre animal</label>
            <select wire:model="selectedAnimalId" id="animal" class="w-full border rounded-lg p-3 mt-2">
                <option value="">Choisir un animal</option>
                @foreach($animals as $animal)
                    <option value="{{ $animal->id }}">{{ $animal->nom }} ({{ $animal->espece->nom }})</option>
                @endforeach
            </select>
        </div>
    @endif

    <!-- Zone de discussion -->
    <div class="bg-gray-100 p-6 rounded-lg shadow-md text-center"
         x-data="{ typing: false, get notTyping() { return !this.typing; } }"
         x-init="
         window.Livewire.on('startTyping', () => typing = true);
         window.Livewire.on('stopTyping', () => typing = false);
     ">

        @foreach($messages as $message)
            <div class="mb-4">
                @if($message['role'] === 'user')
                    <div class="flex">
                        <p class="text-right text-gray-700 font-medium bg-gray-200 p-3 rounded-lg inline-block max-w-xl">
                            {{ $message['content'] }}
                        </p>
                        <img src="{{ asset('img/logo/default_avatar.jpg') }}" alt="Logo" class="w-12 h-12 rounded-full ml-4">
                    </div>
                @else
                    <div class="flex items-center space-x-4">
                        <p class="text-left text-black-700 font-medium italic rounded-lg inline-block max-w-xl mb-5">
                            L'Assistant IA de Doctopet a dit :
                        </p>
                    </div>
                    <div class="flex">
                        <img src="{{ asset('img/logo/doctopet_logo_green_on_white.png') }}" alt="Logo" class="w-12 h-12 rounded-full mr-4">
                        <p class="text-left text-green-700 font-medium bg-green-100 p-3 rounded-lg inline-block max-w-xl">
                            {{ $message['content'] }}
                        </p>
                    </div>
                @endif
            </div>
        @endforeach

            <!-- Animation de chargement -->
            <div id="animation-gif" class=" hidden items-center justify-center mt-4">
                <img src="{{ asset('img/assistant/chargement.gif') }}" alt="Chargement" class="w-20 h-16">
                <p class="text-gray-500 italic ml-2">Doctopet AI réfléchit...</p>
            </div>

            <!-- Message par défaut -->
            <div x-show="!isTyping" class="flex items-center justify-center mt-4">
                <p class="text-gray-500 italic ml-2">Posez votre question à Doctopet AI.</p>
            </div>

    </div>


    <!-- Entrée de la question -->
    <div class="mt-6 flex">
        <input
            id="question-input"
            type="text"
            class="flex-grow border rounded-l-lg p-3"
            placeholder="Posez votre question...">
        <button
            onclick="submitQuestion()"
            class="bg-green-600 text-white px-6 rounded-r-lg hover:bg-green-700">
            Envoyer
        </button>
    </div>

    <script>
        function submitQuestion() {
            const question = document.getElementById('question-input').value;

            let anim = document.getElementById("animation-gif");
            anim.style.display = "flex"
            console.log("J'envoie la question:", question);

            // Utilisation de Livewire.dispatch pour envoyer l'événement
            Livewire.dispatch('submitQuestion', {question});

            // Réinitialiser le champ de saisie
            document.getElementById('question-input').value = '';
        }
    </script>
</div>
