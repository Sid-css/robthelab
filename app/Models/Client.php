<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
        protected $fillable = [
        'name',
        'email',
        'phone',
        'company_name',
        'address',
        'requirement_file_link',
        'requirement_details',
    ];
}
