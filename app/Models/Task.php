<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $guarded=['id'];

   public function scopeFilterWithStatus($query, $status)
   {
       if($status != null){
           $query->where('status', $status);
       }
       return $query;
   }

   public function scopeSearchByTitle($query, $title)
   {
       if($title != null){
           $query->where('title', 'LIKE', '%'.$title.'%');
       }
       return $query;
   }

   public function quizzes()
   {
       return $this->hasMany(Quiz::class);
   }
}
