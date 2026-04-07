<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    // Explicitly define the table name because migration uses singular 'client'
    protected $table = 'client';

    // Explicitly define primary key if it is 'ID' (uppercase)
    protected $primaryKey = 'ID';

    // Disable timestamps because your migration does not have created_at/updated_at
    public $timestamps = false; 

    protected $fillable = [
        'name',
        'phone_number', // Matches DB column
        'email',
        'address',
        'source',       // Matches DB column
    ];
}