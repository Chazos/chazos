<?php 
namespace App\Http\Resources;use Illuminate\Http\Resources\Json\JsonResource;

class CatsResource extends JsonResource {
	public function toArray($request) {
		return [
			'id' => $this->id,
			'cat_name' => $this->cat_name,
			'breed' => $this->breed,
			'avatar' => $this->getMedia('avatar'),
			'description' => $this->description,
			'created_at' => $this->created_at,
			'updated_at' => $this->updated_at
		];
	}
}
