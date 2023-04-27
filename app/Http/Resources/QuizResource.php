<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QuizResource extends JsonResource
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
            "task"=>TaskResource::make($this->whenLoaded('task')), 
            "questions"=>QuestionResource::collection($this->whenLoaded('questions'))
        ];
    }
}
