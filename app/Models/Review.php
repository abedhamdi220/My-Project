<?php

namespace App\Models;

use App\Models\Media;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
protected $fillable = ["order_id","user_id","rating","comment"] ;
public function user(){
    return $this->belongsTo(User::class);
}
    
public function order(){
    return $this->belongsTo(Order::class);
}
public function media(){
    return $this->morphMany(Media::class,"mediable");
}
}


