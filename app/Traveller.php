<?php

namespace App;

use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;

class Traveller extends Model
{
    protected $primaryKey = 'id_traveller';
    // protected $dates = ['date_of_birth'];
    protected $fillable = ['first_name', 'last_name', 'gender', 'date_of_birth', 'country', 'currently_live_at', 'phone_number', 'job', 'photo', 'bio', 'status', 'user_id'];
    public $timestamps = false;

    public function getAgeAttribute()
    {
        return Carbon::parse($this->attributes['date_of_birth'])->age;
    }
}
