<div class="p-6 bg-white shadow-md bg-gray-100 rounded-lg  mx-auto w-fill-available">
    <h2 class="text-2xl font-bold text-green-700 mb-4">📩 Contacter l'éleveur</h2>

    <p class="text-gray-600 mb-2">Éleveur : <strong>{{ $breeder->name }}</strong></p>
    <p class="text-gray-600 mb-4">📍 Localisation : {{ $breeder->address }}</p>

    <textarea wire:model="message" class="w-full h-40 p-4 border rounded-lg text-gray-700"></textarea>

    <div class="flex items-center my-4">
        <input type="checkbox" wire:model="sendMessageInternally" id="internalMessage" class="mr-2">
        <label for="internalMessage" class="text-gray-700">Envoyer aussi via la messagerie Doctopet</label>
    </div>

    <button wire:click="send" class="w-full bg-green-500 text-white py-2 px-4 rounded-lg hover:bg-green-600 transition">
        🚀 Envoyer mon message
    </button>

    @if(session()->has('success'))
        <p class="text-green-600 mt-2">{{ session('success') }}</p>
    @endif
</div>
