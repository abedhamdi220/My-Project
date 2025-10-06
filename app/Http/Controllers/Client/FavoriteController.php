<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Global\FavoriteRequest;
use App\Http\Servicses\Client\FavoriteService;
use App\Models\Service;
use Illuminate\Http\Request;


class FavoriteController extends Controller
{
    protected $FavoriteService;
public function __construct(FavoriteService $service){
    $this->FavoriteService = $service;

}
    public function index(Request $request){
        $favorite=$this->FavoriteService->getFavorite();
        return response()->json(["data"=>$favorite,"message"=> "list of favorite services for client"],200);
    }
    public function store($id){
        $this->FavoriteService->storeFavorite($id);
        return response()->json(["data"=>null,"message"=> "your service added to favorite "],201);
    }
    public function destroy($id){
        $this->FavoriteService->destroyFavorite($id);
        return response()->json(["message"=> "the servise has been deleted from favorite"],200);
    }
}
