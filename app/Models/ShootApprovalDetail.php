<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShootApprovalDetail extends Model
{
    protected $table = 'shoot_approval_details';
    protected $primaryKey = 'ID';
    public $timestamps = false; // Your table definition doesn't show created_at/updated_at

    protected $fillable = [
        'client_id',
        'shoot_details_id',
        'status',
    ];
}