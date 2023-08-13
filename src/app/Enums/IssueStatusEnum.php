<?php

namespace App\Enums;

enum IssueStatusEnum:string {
    case PAUSED = "paused";
    case IN_PROGRESS = "in progress";
    case TESTING = "testing";
    case COMPLETED = "completed";
}