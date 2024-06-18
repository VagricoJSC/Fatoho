<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Tracker extends Model
{
    protected $fillable=['order_id', 'data', 'created_at', 'updated_at'];

    

}
