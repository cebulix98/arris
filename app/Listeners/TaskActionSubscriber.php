<?php

namespace App\Listeners;

use App\Events\TaskCompleted;
use App\Notifications\TaskCompletedNotification;
use Illuminate\Events\Dispatcher;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class TaskActionSubscriber
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        //
    }

    public function taskCompleted(TaskCompleted $event)
    {
        $event->task->user()->getResults()->notify(new TaskCompletedNotification($event->task->name));
    }

    public function subscribe(Dispatcher $events): array
    {
        return [
            TaskCompleted::class => 'taskCompleted'
        ];
    }
}
