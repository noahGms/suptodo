<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todolist extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'created_by' => 'int'
    ];

    public function CreatedBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
