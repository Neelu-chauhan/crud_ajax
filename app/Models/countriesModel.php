<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class countriesModel extends Model
{
    protected $table ='countries';
    protected $fillable =['countries_name','id'];
}
