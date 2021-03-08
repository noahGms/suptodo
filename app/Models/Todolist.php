<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Todolist extends Model
{
    use HasFactory;

    protected $guarded = [];

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
}
