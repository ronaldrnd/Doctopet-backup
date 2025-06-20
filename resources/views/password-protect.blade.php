@vite('resources/css/app.css')


<div class="min-h-screen bg-gray-100 flex items-center justify-center">
    <form method="POST" action="/password-protect" class="bg-white p-6 rounded shadow">
        @csrf
        <label for="password" class="block font-medium text-gray-700">Mot de passe :</label>
        <input type="password" id="password" name="password" class="w-full p-2 border rounded">
        @error('password')
        <p class="text-red-500 mt-2">{{ $message }}</p>
        @enderror
        <button type="submit" class="mt-4 bg-green-600 text-white px-4 py-2 rounded">Entrer</button>
    </form>
</div>
