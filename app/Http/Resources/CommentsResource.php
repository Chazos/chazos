<?php 
namespace App\Http\Resources;use Illuminate\Http\Resources\Json\JsonResource;

class CommentsResource extends JsonResource {
	public function toArray($request) {
		return [
			'id' => $this->id,
			'user_id' => $this->user_id,
			'blog_id' => $this->blog_id,
			'comment' => $this->comment,
			'likes' => $this->likes,
			'dislikes' => $this->dislikes,
			'created_at' => $this->created_at,
			'updated_at' => $this->updated_at
		];
	}
}
