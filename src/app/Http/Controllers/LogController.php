<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserActionCollection;
use App\Models\UserAction;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function logs(Request $request) 
    {
        $logs = UserAction::query()->with(['user', 'actionable'])->orderByDesc('id')->paginate(10);
        return new UserActionCollection($logs);
    }
}