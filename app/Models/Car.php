<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $primaryKey = 'registration_number';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'registration_number',
        'make',
        'model',
        'year',
        'kilometers',
        'color',
        'fuel_type',
        'gearbox',
        'price',
        'status',
        'description',
        'arrived_date',
    ];
}
