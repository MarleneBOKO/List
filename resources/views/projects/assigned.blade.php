<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Assigned Tasks for') }} {{ $project->message }}
        </h2>
    </x-slot>

    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
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
                            <div>
                                @if ($task->users->contains(auth()->user()) && !$task->completed)
                                    <x-dropdown>
                                        <x-slot name="trigger">
                                            <button>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                                </svg>
                                            </button>
                                        </x-slot>
                                        <x-slot name="content">
                                            <form method="POST" action="{{ route('tasks.markAsCompleted', $task) }}">
                                                @csrf
                                                <x-dropdown-link :href="route('tasks.markAsCompleted', $task)" onclick="event.preventDefault(); this.closest('form').submit();">
                                                    @if ($task->completed)
                                                        <span class="text-green-500">{{ __('(En cours)') }}</span> &middot;
                                                    @else
                                                        {{ __('Mark As Completed') }}
                                                        <span class="text-green-500">{{ __('(Terminer)') }}</span> &middot;
                                                    @endif
                                                </x-dropdown-link>
                                            </form>
                                        </x-slot>
                                    </x-dropdown>
                                @endif
                            </div>
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
    </div>
</x-app-layout>
