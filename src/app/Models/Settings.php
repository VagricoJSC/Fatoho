<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    protected $fillable=['short_des','description','photo','address','phone','email','logo','bank', 'map_location', 'facebook', 'youtube','instagram', 'footer_description', 'corp_name', 'corp_num', '	corp_reg_date', 'corp_reg_place'];

	protected $casts = [
        'corp_reg_date' => 'date'
    ];

	
}
