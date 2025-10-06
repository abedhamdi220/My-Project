<?php

namespace App\Http\Servicses\Client;

use App\Models\Service;
use Illuminate\Support\Facades\Auth;

class FavoriteService
{
    public function getFavorite()
    {
        $favorite = Auth::user()->favorites()->where("user_id", Auth::user()->id)->firstOrFail();
        return $favorite;
    }
    public function storeFavorite($id){

        $service =Service::where("id", $id)->where("status","active")->firstOrFail();
        $exists = Auth::user()->favorites()->where("user_id", $service->id)->exists();
        if($exists){
            abort(409,"you have already this service in favorite list");
        }
        Auth::user()->favorites()->syncWithoutDetaching($service->id);
    }
    public function destroyFavorite($id){
         $service =Service::where("id", $id)->firstOrFail();
          $exists = Auth::user()->favorites()->where("user_id", $service->id)->exists();
        if(!$exists){
            abort(404,"service not found");
        }
        Auth::user()->favorites()->detach($service->id);

    }
}
