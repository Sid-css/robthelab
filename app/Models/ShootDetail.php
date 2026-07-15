<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShootDetail extends Model
{
    protected $table = 'shoot_details';
    protected $primaryKey = 'ID';
    public $timestamps = false;

    protected $fillable =[
        'client_id',
        'booking_id', // <--- Added this
        'shoot_type',
        'shoot_location',
        'status',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'ID');
    }
}