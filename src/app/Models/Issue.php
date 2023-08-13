<?php

namespace App\Models;

use App\Enums\IssueStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasChildren;
use Illuminate\Database\Eloquent\SoftDeletes;

class Issue extends Model
{
    use HasChildren, HasFactory, SoftDeletes;

    protected $fillable = ['title', 'type', 'status', 'user_id', 'tester_id', 'performer_id', 'description'];

    protected $childTypes = [
        'task' => Task::class,
        'bug' => Bug::class,
    ];

    protected $casts = [
        'status' => IssueStatusEnum::class
    ];

    protected $appends = ['tag_class', 'trashed'];


    public function getChildTypes() {
        return $this->childTypes;
    }

    public function getTagClassAttribute()
    {
        return 'bg-blue-300';
    }

    public function getTrashedAttribute()
    {
        return $this->trashed();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tester()
    {
        return $this->belongsTo(User::class, 'tester_id');
    }

    public function performer()
    {
        return $this->belongsTo(User::class, 'performer_id');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable')->whereNull('parent_id');
    }

    public function paramToChange($key, $value) 
    {
        $original = $this->getOriginal();

        if(in_array($key, ['user_id', 'tester_id', 'performer_id'])) {
            $keyWithoutId = str_replace('_id', '', $key);

            $user = User::find($original[$key]);
            $newUser = User::find($value);

            return [
                $keyWithoutId => [
                    'original' => $user->name,
                    'changes' => $newUser->name
                ]
            ];
        }

        return [
            $key => [
                'original' => $original[$key],
                'changes' => $value,
            ]
        ];
    }
}
