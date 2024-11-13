<!-- resources/views/notes/show.blade.php -->

<x-app-layout>
    <div class="my-6 p-6 bg-white border-b border-gray-200 shadow-sm sm:rounded-lg">
        <h2 class="font-semibold text-xl">{{ $note->title }}</h2>
        <p class="mt-2">{{ $note->text }}</p> <!-- Teljes szöveg megjelenítése -->

        <span>Létrehozva: {{ $note->created_at ? $note->created_at->diffForHumans() : 'N/A' }}</span>
      


@if ($note->updated_at && $note->updated_at != $note->created_at)
    <span>Módosítva: {{ $note->updated_at ? $note->updated_at->diffForHumans() : 'N/A' }}</span>
@endif
<div class="flex items-center space-x-4">
<a href="{{ route('notes.edit', $note) }}" class="btn-link ml-auto">Szerkesztés</a>

<!-- Törlés gomb -->
<button type="button" class="btn btn-danger ml-4" onclick="confirmDelete()">Törlés</button>

<!-- Törlés űrlap -->
<form id="deleteForm" action="{{ route('notes.destroy', $note) }}" method="post" style="display:none;">
    @method('delete')
    @csrf
</form>
    </div>
     <!-- Vissza link a főoldalra -->
     <a href="{{ route('notes.index') }}" class="text-blue-500 hover:underline">Vissza a jegyzetekhez</a>
</div>
<x-alert-success>
    {{ session('success') }}
</x-alert-success>


   
</x-app-layout>
