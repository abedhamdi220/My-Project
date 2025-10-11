<?php

namespace App\Models;

use App\Models\Media;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'provider_id',
        'category_id',
        'status'
    ];

    public function provider()
    {
        return $this->belongsTo(User::class, 'provider_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function favoritesBy()
    {
        return $this->belongsToMany(User::class, 'favorites', 'service_id', 'user_id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
    public function media()
    {
        return $this->morphMany(Media::class, "mediable");
    }

    public function getImageUrlAttribute()
    {
        return optional($this->media->first())->full_url;
    }
}
