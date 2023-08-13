<?php

namespace App\Http\Controllers;

use App\Models\Issue;
use App\Models\Task;

class PageController extends Controller
{
    public function home()
    {
        return view('welcome');
    }
}
