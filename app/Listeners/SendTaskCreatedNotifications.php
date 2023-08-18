<?php

namespace App\Listeners;

use App\Events\TaskCreated;
use App\Models\User;
use App\Notifications\NewTask;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendTaskCreatedNotifications implements ShouldQueue{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(TaskCreated $event): void
    {
        foreach (User::whereNot('id', $event->task->user_id)->cursor() as $user) {
            $user->notify(new NewTask($event->task));
        }
    }
}
