<?php

namespace App\Listeners;

use App\Events\NewRecord;
use App\Jobs\ExecuteWorkflowJob;
use App\Models\Trigger;
use App\Models\Workflow;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Log;

class HandleNewRecord
{
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
    public function handle(NewRecord $event): void
    {
        $workflows = Trigger::where('type', 'event')
            ->where('name', 'MyTable new record')
            ->whereHas('workflow', function ($query) {
                $query->where('is_active', 1);
            })
            ->with('workflow')
            ->get()
            ->pluck('workflow');

        foreach ($workflows as $workflow) {
            ExecuteWorkflowJob::dispatch($workflow, $event->record);
        }
    }
}
