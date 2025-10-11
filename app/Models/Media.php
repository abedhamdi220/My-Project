<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Media extends Model
{
    protected $fillable = ['file_name', 'file_path', 'mime_type', 'file_size'];
    public function mediable()
    {
        return $this->morphTo();
    }
    public function getFileUrlAttribute()
    {
        return asset('storage/' . $this->file_path);
    }
    // public function getUrlAttribute(){
    //     return Storage::disk('public')->url($this->file_path);

    // }
}
