<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShootMaster extends Model
{
    protected $table = 'shoot_master';
    protected $primaryKey = 'ID';
    public $timestamps = false;

    protected $fillable =[
        'requirements_id', // <-- Add this
        'type_of_shoot',
        'shoot_description',
    ];
}