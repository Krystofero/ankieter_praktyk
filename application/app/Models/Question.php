<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    // protected $guarded = [];

    protected $table = 'questions';

   /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'question',
        'type',
        'questionnaire_id'
    ];

    public function questionnaire(Questionnaire  $questionnaire)
    {
        return $this->belongsTo(Questionnaire::class);
    }

    public function answers()
    {
        // return $this->hasMany(Answer::class);
        return $this->hasMany(Answer::class, 'question_id');
    }

    public function responses()
    {
        return $this->hasMany(Response::class, 'question_id');
    }

}
