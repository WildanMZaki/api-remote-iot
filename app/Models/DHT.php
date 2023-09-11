<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DHT extends Model
{
    protected $table = 'dht_sensor';

    protected $primaryKey = 'moment'; // Specify the primary key column name

    protected $fillable = ['moment', 'temperature', 'humidity'];

    public $incrementing = false; // Disable auto-incrementing primary key
}
