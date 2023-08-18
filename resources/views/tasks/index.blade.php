
<x-app-layout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <form id="task-form" method="POST" action="{{ route('tasks.store') }}">
            @csrf
            <textarea
                name="message"
                placeholder="{{ __('So what do we do today?') }}"
                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
            >{{ old('message') }}</textarea>

            <x-input-error :messages="$errors->get('message')" class="mt-2" />

            <x-primary-button  id="submit-button" class="mt-4">{{ __('task') }}</x-primary-button>
        </form>
        @if(session('success'))
        <div class="flex items-center p-4 mb-4 text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400" role="alert">
                <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                </svg>
                <span class="sr-only">Info</span>
                <div class="ml-3 text-sm font-medium">
         {{ session('success') }}
            </div>
            <button type="button" id="close-alert" class=" ml-auto -mx-1.5 -my-1.5 bg-green-50 text-bleu-500 rounded-lg focus:ring-2 focus:ring-blue-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700" data-dismiss-target="#alert-3" aria-label="Close">
                <span class="sr-only">Close</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
            </button>
        </div>

    @elseif(session('danger'))
        <div class="flex items-center p-4 mb-4 text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
            <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
            </svg>
            <span class="sr-only">Info</span>
            <div class="ml-3 text-sm font-medium">
        {{ session('danger') }}
            </div>
            <button type="button" id="close-alert" class=" ml-auto -mx-1.5 -my-1.5 bg-green-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700" data-dismiss-target="#alert-3" aria-label="Close">
                <span class="sr-only">Close</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
            </button>
        </div>
        @elseif(session('warning'))
        <div class="flex items-center p-4 mb-4 text-yellow-800 rounded-lg bg-yellow-50 dark:bg-gray-800 dark:text-yellow-400" role="alert">
            <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
            </svg>
            <span class="sr-only">Info</span>
            <div class="ml-3 text-sm font-medium">
         {{ session('warning') }}
        </div>
        <button type="button"id="close-alert" class=" ml-auto -mx-1.5 -my-1.5 bg-green-50 text-yellow-500 rounded-lg focus:ring-2 focus:yellow-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700" data-dismiss-target="#alert-3" aria-label="Close">
            <span class="sr-only">Close</span>
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
            </svg>
        </button>
    </div>
    @endif


    </form>

        <div class="mt-6 bg-white shadow-sm rounded-lg divide-y">
            @foreach ($tasks as $task)
                <div class="p-6 flex space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 -scale-x-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    <div class="flex-1">
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="text-gray-800">{{ $task->user->name }}</span>
                                <small class="ml-2 text-sm text-gray-600">{{ $task->created_at->format('j M Y, g:i a') }}</small>
                                @unless ($task->created_at->eq($task->updated_at))
                                    <small class="text-sm text-gray-600"> &middot; {{ __('edited') }}</small>
                                @endunless
                            </div>
                            @if ($task->user->is(auth()->user()))
                                <x-dropdown>
                                    <x-slot name="trigger">
                                        <button>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                            </svg>
                                        </button>
                                    </x-slot>
                                    <x-slot name="content">
                                        <x-dropdown-link :href="route('tasks.edit', $task)">
                                            {{ __('Edit') }}

                                            <form method="POST" action="{{ route('tasks.destroy', $task) }}">
                                                @csrf
                                                @method('delete')
                                                <x-dropdown-link :href="route('tasks.destroy', $task)" onclick="event.preventDefault(); this.closest('form').submit();">
                                                    {{ __('Delete') }}
                                                </x-dropdown-link>
                                            </form>

                                            <form method="POST" action="{{ route('tasks.markAsCompleted', $task) }}">
                                                 @csrf
                                                <x-dropdown-link :href="route('tasks.markAsCompleted', $task)" onclick="event.preventDefault(); this.closest('form').submit();">
                                                    @if ($task->completed)
                                                    <span class="text-green-500">{{ __('(Terminer)') }}</span> &middot;
                                                        {{ __('Mark As Completed') }}
                                                    @else
                                                    <span class="text-green-500">{{ __('(En cours)') }}</span> &middot;
                                                    @endif
                                                </x-dropdown-link>


                                            </form>
                                        </x-dropdown-link>
                                    </x-slot>
                                </x-dropdown>
                                @endif
                            </div>
                            <p class="mt-4 text-lg text-gray-900">
                                @if ($task->completed)
                                <span class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-green-400 border border-green-400">Terminer</span> &middot;
                                @else
                                <span class="bg-yellow-100 text-yellow-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-yellow-300 border border-yellow-300">En cours</span> &middot;

                                @endif
                                {{ $task->message }}
                            </p>
                     </div>
                </div>
            @endforeach
        </div>
        @if(isset($user))
    <div class="mt-6 bg-white shadow-sm rounded-lg divide-y">
        @foreach ($user->assignedTasks as $task)
            <div class="p-6">
                {{ $task->message }} (Assignée à : {{ $task->assignedUsers->implode('name', ', ') }})
            </div>
        @endforeach
    </div>
@endif
</x-app-layout>

<script>
    const submitButton = document.getElementById('submit-button');
    const alertBorder = document.getElementById('alert-border-1');
    const closeAlertButton = document.getElementById('close-alert');

    submitButton.addEventListener('click', function () {
        const messageInput = document.querySelector('input[name="message"]');
        if (messageInput.value.trim() !== '') {
            alertBorder.classList.remove('hidden');
            setTimeout(function () {
                alertBorder.classList.add('hidden');
            }, 5000); // Hide after 5 seconds
        }
    });

    closeAlertButton.addEventListener('click', function () {
        alertBorder.classList.add('hidden');
    });
</script>
