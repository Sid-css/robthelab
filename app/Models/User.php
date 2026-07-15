<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // IMPORTANT: Tell Laravel your primary key is uppercase 'ID'
    protected $primaryKey = 'ID';

    // IMPORTANT: Tell Laravel your table doesn't have created_at and updated_at
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable =[
        'name',
        'email',
        'number', // Added this based on your migration
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return[
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}