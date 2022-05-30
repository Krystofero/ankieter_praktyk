<?php

namespace App\Http\Controllers;

use App\Models\Questionnaire;
use App\Models\Question;
use Illuminate\Http\Request;
use Exception;

class QuestionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the form for creating new questions on the specified questionnaire.
     *
     * @param  Questionnaire  $questionnaire
     * @return View
     */
    public function create(Questionnaire  $questionnaire)
    {
        return view('question.create', compact('questionnaire'));
    }

    /**
     * Store in storage and save a newly created question.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Questionnaire  $questionnaire)
    {
        $data = request()->validate([
            'type' => 'nullable',
            'question.question' => 'required|String|max:255',
            'answers.*.answer' => 'nullable|String|max:255'
        ]);
        if($data['type'] == "Zamkniete"){
            $question = $questionnaire->questions()->create($data['question']);
            $question->answers()->createMany($data['answers']);
        }
        else{//Pytanie otwarte
            $question = Question::create([
                'questionnaire_id' => $questionnaire->id,
                'question' => $data['question']['question'],
                'type' => "Otwarte"
            ]);

            // $question = $questionnaire->questions()->create($data['question']);
        }

        return redirect(route('questionnairesModerator.show',  $questionnaire->id)); //przekierowanie spowrotem do widoku edycji pytań
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Questionnaire  $questionnaire
     * @param Question  $question
     * @return JsonResponse
     */
    public function destroy(Questionnaire  $questionnaire, Question  $question)
    {   
        try {
            $question->answers()->delete();
            $question->delete();
            // return response()->json([
            //     'status' => 'success'
            // ]);
            return redirect(route('questionnairesModerator.show',  $questionnaire->id));
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Wystąpił błąd!'
            ])->setStatusCode(500);
        }
    }

}
