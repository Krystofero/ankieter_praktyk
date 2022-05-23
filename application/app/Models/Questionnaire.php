<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Questionnaire extends Model
{
    use HasFactory;

    // protected $guarded = []; //wyłączam całą ochronę dla modelu

    protected $table = 'questionnaires';

   /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        // 'questionnaire',
        'title',
        'user_id',
        'startdate',
        'enddate'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //Questionnaire = collection of questions
    public function questions()
    {
        // return $this->hasMany(Question::class);
        return $this->hasMany(Question::class, 'questionnaire_id');
    }
}
