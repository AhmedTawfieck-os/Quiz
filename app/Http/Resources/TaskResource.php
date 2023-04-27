<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "title"=>$this->title, 
            "subject"=>$this->subject, 
            "description"=>$this->description, 
            "status"=>$this->status, 
            "user_id"=>$this->user_id,
            "quizzes"=>QuizResource::collection($this->whenLoaded('quizzes'))
        ];
    }
}
