<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Todolist extends Model
{
    use HasFactory;

    protected $guarded = ['participants'];

    protected $casts = [
        'created_by' => 'int'
    ];

    public function CreatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function Todoitems(): HasMany
    {
        return $this->hasMany(Todoitem::class, 'todolist_id');
    }

    public function Participants(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'todolists_has_participants', 'todolist_id', 'user_id')->withPivot('accepted');
    }
}
