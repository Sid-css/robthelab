<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'name',
        'ph_no',
        'email',
        'address',
        'source_id',
    ];

    // public function source()
    // {
    //     return $this->belongsTo(SourceMaster::class, 'source_id');
    // }

    // public function shootDetails()
    // {
    //     return $this->hasMany(ShootDetail::class);
    // }
}
