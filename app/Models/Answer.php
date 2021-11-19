<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $fillable = ['answer', 'user_id', 'question_id'];

    function question()
    {
        return $this->hasOne(Question::class);
    }

    function user()
    {
        return $this->belongsTo(User::class);
    }
}
