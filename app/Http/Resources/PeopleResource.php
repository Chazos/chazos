<?php 
namespace App\Http\Resources;use Illuminate\Http\Resources\Json\JsonResource;

class PeopleResource extends JsonResource {
	public function toArray($request) {
		return [
			'id' => $this->id,
			'name' => $this->name,
			'age' => $this->age,
			'created_at' => $this->created_at,
			'updated_at' => $this->updated_at
		];
	}
}
