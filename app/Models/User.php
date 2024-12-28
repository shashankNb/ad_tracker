<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    const RULES = [
        'name' => 'required',
        'email' => 'required|unique:users',
        'username' => 'required|unique:users',
        'password' => 'required'
    ];

    const MESSAGES = [
        'name.required' => 'Name is required.',
        'email.required' => 'Email is required.',
        'username.required' => 'Username is required.',
        'email.unique' => 'User with this email already exists.',
        'username.unique' => 'User with this username already exists.',
        'password.required' => 'Password is required.'
    ];
}
