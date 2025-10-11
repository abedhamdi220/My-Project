<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $fillable = ['file_name', 'file_path', 'mime_type', 'file_size'];
    public function mediable()
    {
        return $this->morphTo();
    }
    public function getFullurlAttribute()
    {
        return asset('storage/' . $this->file_path);
    }
}
