<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
class Booking extends Model
{

    use SoftDeletes;
    use HasFactory;
    use Notifiable;
    protected $fillable = [
        'room_id',
        'start',
        'end',
        'is_reservation',
        'is_paid',
        'notes',


    ];

    public function room(){

        return $this->belongsTo('App\Models\Room');

    }

    public function users(){

        return $this->belongsToMany('App\Models\User','bookings_users','booking_id','user_id')->withTimestamps();

    }
}
