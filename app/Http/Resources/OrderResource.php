<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\PaymentResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Validation\ValidatesWhenResolvedTrait;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "status" => $this->status,
            "notes" => $this->notes,
            "client_id" => $this->client_id,
            "provider_id" => $this->provider_id,
            "service_id" => $this->service_id,
            "created_at" => $this->created_at->format("Y-m-d H:i:s"),
            "updated_at" => $this->updated_at->format("Y-m-d H:i:s"),

            "rate"=>new ReviewResource($this->whenLoaded("review")),
            "rating"=>$this->whenLoaded("review", function () {
                return $this->review ? $this->review->rating : null;
            }),
            "comment"=>$this->whenLoaded("review", function () {
                return $this->review ? $this->review->comment : null;
            }),
           // "payment"=>PaymentResource($this->whenLoaded("payment")),



        ];
    }
}
