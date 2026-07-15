<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SourceMaster extends Model
{
    // Map to your specific table name
    protected $table = 'source_master';

    // Define the primary key
    protected $primaryKey = 'ID';

    // Disable timestamps since your migration doesn't have created_at/updated_at
    public $timestamps = false; 

    protected $fillable = [
        'type_of_source',
    ];
}