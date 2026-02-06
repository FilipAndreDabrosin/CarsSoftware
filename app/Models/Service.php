<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'registration_number',
        'type',
        'priority',
        'title',
        'description',
        'estimated_cost',
        'real_cost',
        'scheduled_date',
        'completed_date',
        'mechanic',
    ];
}
