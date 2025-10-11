<?php

namespace App\Http\Servicses\Global;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class MediaService{
    public function storeMedia(Model $model,$file,string $folder="uploads")
    {
      $path=$file->store($folder,'public');
      return $model->media()->create([
        'file_name'=>$file->getClientOriginalName(),
        'file_path'=>$path,
        'mime_type'=>$file->getMimeType(),
      ]);
    }
    public function deleteOldMedia(Model $model)
    {
      $oldMedia=$model->media()->first();
      if($oldMedia){
        Storage::disk('public')->delete($oldMedia->file_path);
        $oldMedia->delete();
      }

    }
      public function updateMedia(Model $model,$file,string $folder="uploads")
    {
      $this->deleteOldMedia($model);
      return $this->storeMedia($model,$file,$folder);
    }

    
}