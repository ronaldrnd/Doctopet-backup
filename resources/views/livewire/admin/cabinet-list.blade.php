<div class="p-6 bg-white shadow-md rounded-lg">
    <h2 class="text-2xl font-bold text-gray-800 mb-4">📍 Liste des Cabinets</h2>

    <table class="w-full border-collapse border border-gray-300">
        <thead class="bg-gray-200">
        <tr>
            <th class="border p-2">ID</th>
            <th class="border p-2">Nom</th>
            <th class="border p-2">Adresse</th>
            <th class="border p-2">Nombre de vétérinaires</th>
            <th class="border p-2">Numero de téléphone</th>
            <th class="border p-2">Actions</th>
            <th class="border p-2">Date de création</th>

        </tr>
        </thead>
        <tbody>
        @foreach($cabinets as $cabinet)
            <tr class="text-center">
                <th class="border p-2">{{$cabinet->id}}</th>
                <td class="border p-2">{{ $cabinet->nom }}</td>
                <td class="border p-2">{{ $cabinet->adresse }}</td>
                <td class="border p-2">{{ $cabinet->veterinaires_count }}</td>
                <td class="border p-2">{{$cabinet->tel}}</td>
                <td class="border p-2">{{$cabinet->created_at}}</td>
                <td class="border p-2">
                    <button
                            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
                        <a href="{{route("admin.edit_cabinet",$cabinet->id)}}">
                            ✏ Modifier
                        </a>
                    </button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
