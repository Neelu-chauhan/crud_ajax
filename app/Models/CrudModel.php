<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CrudModel extends Model
{
    protected $table = 'crud_models';
    protected $fillable = ['name', 'email', 'country_id_fk','address','status'];

    public function country(){
        return $this->belongsTo(countriesModel::class,'country_id_fk','id');
    }
}
