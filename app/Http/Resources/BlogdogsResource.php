<?php 
namespace App\Http\Resources;use Illuminate\Http\Resources\Json\JsonResource;

class BlogdogsResource extends JsonResource {
	public function toArray($request) {
		return [
			'id' => $this->id,
			'topic' => $this->topic,
			'except' => $this->except,
			'image' => $this->getMedia('image'),
			'story' => $this->story,
			'user_id' => $this->user_id,
			'created_at' => $this->created_at,
			'updated_at' => $this->updated_at
		];
	}
}
