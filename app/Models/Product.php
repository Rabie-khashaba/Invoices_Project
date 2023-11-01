<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded =[];

    public $timestamps = true;

    public function section(){
       return $this->belongsTo('App\Models\Section','section_id');
    }
}
