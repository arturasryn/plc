<?php

namespace App\Models;

use App\Models\Issue;
use App\Traits\HasParent;

class Task extends Issue
{
    use HasParent;
}