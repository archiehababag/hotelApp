<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    public function roomType(){
        return $this->belongsTo(RoomType::class, 'room_type_id', 'id');
    }

    public function room_number(){
        return $this->hasMany(RoomNumber::class, 'room_id')->where('status', 'Active');

    }
    
}
