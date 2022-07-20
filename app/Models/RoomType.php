<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class RoomType extends Model
{
    use HasFactory;
    protected $table = 'room_types';
    protected $primaryKey = 'id';
    public $timestamps = true;


    public function room(){

        return $this->hasOne('App\Models\Room');

    }

    public function rooms(){

        return $this->hasMany('App\Models\Room','id','room_type_id');


    }
}
