<?php

namespace App\Observers;

use App\Models\Issue;
use App\Models\User;
use App\Models\UserAction;
use Illuminate\Support\Facades\Auth;

class IssueObserver
{
    /**
     * Handle the Issue "created" event.
     */
    public function created(Issue $issue): void
    {
        if (Auth::check()) {
            UserAction::create([
                'user_id'      => Auth::user()->id,
                'action'       => __FUNCTION__,
                'actionable_type' => $issue->type,
                'actionable_id'    => $issue->id,
            ]);
        }
    }

    /**
     * Handle the Issue "updated" event.
     */
    public function updated(Issue $issue): void
    {
        if (Auth::check()) {
            $changes = [];

            foreach ($issue->getChanges() as $key => $value) {
                $changes = array_merge($changes, $issue->paramToChange($key, $value));
            }


            UserAction::create([
                'user_id' => Auth::user()->id,
                'action' => __FUNCTION__,
                'changes' => $changes,
                'original' => $issue->getOriginal(),
                'new' => $issue->toArray(),
                'actionable_type' => $issue->type,
                'actionable_id'    => $issue->id,
            ]);
        }
    }

    /**
     * Handle the Issue "deleted" event.
     */
    public function deleted(Issue $issue): void
    {
        if (Auth::check()) {
            UserAction::create([
                'user_id'      => Auth::user()->id,
                'action'       => __FUNCTION__,
                'actionable_type' => $issue->type,
                'actionable_id'    => $issue->id,
            ]);
        }
    }

    /**
     * Handle the Issue "restored" event.
     */
    public function restored(Issue $issue): void
    {
        //
    }

    /**
     * Handle the Issue "force deleted" event.
     */
    public function forceDeleted(Issue $issue): void
    {
        //
    }
}
