<?php 
namespace App\Http\Resources;use Illuminate\Http\Resources\Json\JsonResource;

class UsersResource extends JsonResource {
	public function toArray($request) {
		return [
			'id' => $this->id,
			'id' => $this->id,
			'email' => $this->email,
			'name' => $this->name,
			'email_verified_at' => $this->email_verified_at,
			'password' => $this->password,
			'remember_token' => $this->remember_token,
			'created_at' => $this->created_at,
			'updated_at' => $this->updated_at
		];
	}
}
