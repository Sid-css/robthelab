<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequirementMaster extends Model
{
    protected $table = 'requirements_master';
    protected $primaryKey = 'ID';
    public $timestamps = false;

    protected $fillable = [
        'types_of_requirements',
        'description',
    ];
}