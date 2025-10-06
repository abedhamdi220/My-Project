<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        "notes",
        "provider_id",
        "service_id",
        "client_id",
        "status",
        
       
    ] ;
    public function service(){
        return $this->belongsTo(Service::class);
    }
     public function provider(){
        return $this->belongsTo(User::class,"provider_id");
    }
       public function client(){
        return $this->belongsTo(User::class,"client_id");
    }
   
   
    
}
