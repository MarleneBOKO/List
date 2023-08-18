
<x-app-layout>

    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <form method="POST" action="{{ route('tasks.update', $task) }}">
            @csrf
            @method('patch')
            <textarea
                name="message"
                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
            >{{ old('message', $task->message) }}</textarea>
            <x-input-error :messages="$errors->get('message')" class="mt-2" />

            <!-- Ajoutez la liste déroulante de sélection d'utilisateurs -->
            <!-- Champ de sélection de l'utilisateur -->


            <div class="mt-4 space-x-2">
                <label>
                    <input type="checkbox" name="completed" value="1" @if ($task->completed) checked @endif>
                    {{ __('Mark as Completed') }}
                </label>
                <br><br>
                <div class="mt-4 space-x-2">
                    <x-primary-button>{{ __('Save') }}</x-primary-button>
                    <a href="{{ route('tasks.index') }}">{{ __('Cancel') }}</a>
                </div>
            </div>
        </form>
    </div>

</x-app-layout>

