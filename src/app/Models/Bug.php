<?php

namespace App\Models;

use App\Models\Issue;
use App\Traits\HasParent;

class Bug extends Issue
{
    use HasParent;

    public function getTagClassAttribute()
    {
        return 'bg-red-300';
    }
}