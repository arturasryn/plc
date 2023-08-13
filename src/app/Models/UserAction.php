<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAction extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'action', 'changes', 'original', 'new', 'actionable_id', 'actionable_type'];
    protected $casts = [
        'changes' => 'array',
        'original' => 'array',
        'new' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function actionable()
    {
        return $this->morphTo()->withTrashed();
    }
}
