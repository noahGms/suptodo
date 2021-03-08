<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Todoitem extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'todolist_id' => 'int'
    ];

    public function Todolist(): BelongsTo
    {
        return $this->belongsTo(Todolist::class, 'todolist_id');
    }
}
