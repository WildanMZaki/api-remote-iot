<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pin extends Model
{
    protected $primaryKey = 'pin'; // Specify the primary key column name

    protected $fillable = ['pin', 'state'];

    public $incrementing = false; // Disable auto-incrementing primary key

}
