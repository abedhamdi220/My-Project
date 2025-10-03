<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // added description to fillable so it can be created/updated via mass assignment
    protected $fillable = ["name", "parent_id", "description"];

    public function parent(){
        return $this->belongsTo(Category::class, "parent_id");
    }

    public function children(){
        return $this->hasMany(Category::class, "parent_id");
    }

    public function scopeParentId($query, $parentId){
        return $query->where("parent_id", $parentId);
    }

    /**
     * Relationship to services (used for withCount('services'))
     */
    public function services()
    {
        return $this->hasMany(\App\Models\Service::class, 'category_id');
    }
}
