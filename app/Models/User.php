<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'username',
        'email',
        'password',
        'profile_pic'
    ];

    protected $hidden = [
        'password',
    ];

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }

    public function TodolistsCreate(): HasMany
    {
        return $this->hasMany(Todolist::class, 'created_by');
    }

    public function Todolists(): BelongsToMany
    {
        return $this->belongsToMany(Todolist::class, 'todolists_has_participants', 'user_id', 'todolist_id')->withPivot('accepted');
    }

    public function TodolistInvitations(): BelongsToMany
    {
        return $this->belongsToMany(Todolist::class, 'todolists_has_participants', 'user_id', 'todolist_id')->withPivot('accepted')->where('accepted', null);
    }

    public function Friends(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'friends', 'user_id', 'friend_id')->withPivot('accepted');
    }

    public function Invitations(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'friends', 'friend_id', 'user_id')->withPivot('accepted')->where('accepted', null);
    }
}
