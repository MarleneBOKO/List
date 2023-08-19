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


<div class="mt-4">
    <label for="user_id" class="block font-medium text-gray-700">Assigner à un utilisateur :</label>
    <select name="user_id" id="user_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
        <option value="" disabled selected>Choisir un utilisateur</option>
        @foreach($users as $user)
            <option value="{{ $user->id }}" @if($task->user_id === $user->id) selected @endif>{{ $user->name }}</option>
        @endforeach
    </select>
    <x-input-error :messages="$errors->get('user_id')" class="mt-2" />
</div>

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
