<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $guarded=['id']; 
    protected $table='quizzes';

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
