<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->when($this->description !== null, $this->description),
            'price' => $this->when($this->price !== null, $this->price),
            'status' => $this->when(isset($this->status), $this->status),
            'image'=>$this->image_url,
            'provider' => $this->whenLoaded('provider', function () {
                if ($this->provider) {
                    return [
                        'id' => $this->provider->id ?? null,
                        'name' => $this->provider->name ?? null,
                        'email' => $this->provider->email ?? null,
                    ];
                }
                return null;
            }),
            'category' => $this->whenLoaded('category', function () {
                if ($this->category) {
                    return [
                        'id' => $this->category->id ?? null,
                        'name' => $this->category->name ?? null,
                    ];
                }
                return null;
            }),
            'created_at' => optional($this->created_at)->toDateTimeString(),
            'updated_at' => optional($this->updated_at)->toDateTimeString(),

            
        ];
    }
}
