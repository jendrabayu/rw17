<?php

namespace App\Listeners;

use App\Events\LogUserActivity;
use App\Models\ActivityLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class StoreActivityLog
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
     * @param  LogUserActivity  $event
     * @return void
     */
    public function handle(LogUserActivity $event)
    {
        ActivityLog::create(
            [
                'user_id' => auth()->id(),
                'previous_url' => url()->previous(),
                'current_url' => url()->current(),
                'file' => $event->file,
                'action' => $event->action
            ]
        );
    }
}
