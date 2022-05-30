<?php

namespace App\Http\Controllers;

use App\Models\Questionnaire;
use Exception;
use App\Models\Survey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

class QuestionnaireController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index() //widok zarządzania własnymi ankietami do wypełnienia
    {
        if (!(Auth::user()) || Auth::user()->user_level != "Student"){
            return redirect('/');
        }else{
            // $surveys = DB::table('surveys')->get()->where('user_id', Auth::user()->id);

            // $iter = 0;
            // foreach($surveys as $survey){
            //     // $collection = collect();
            //     $collect = DB::table('questionnaires')->get()->where('id', $survey->questionnaire_id);
            //     dd($collect);
            //     $questionnaires = 
            //     // $questionnaires[$iter] = DB::table('questionnaires')->get()->where('id', $survey->questionnaire_id);
            //     dd($questionnaires);
            //     // $collection[0] = $questionnaires;
            //     $iter++;
            // }
            

            $questionnaires = DB::table('questionnaires')
            ->join('surveys', 'questionnaires.id', '=', 'surveys.questionnaire_id')
            ->where('surveys.user_id', Auth::user()->id)
            ->get();

            // dd($questionnaires);

            return view('questionnaires.list',[
                // 'surveys' => $surveys, 
                'questionnaires' => $questionnaires, #lista wszystkich ankiet podpiętych do studenta
            ]);
        }
            
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Questionnaire $questionnaire)
    {
        $data = request()->validate([
            'responses.*.answer_id' => 'nullable',
            'responses.*.question_id' => 'required',
            'responses.*.questionnaire_id' => 'required',
            'responses.*.answer_text' => 'nullable|String|max:255',
            'questionnaire_id' => 'required'
        ]);
        // $data['survey']['user_id'] = Auth::user()->id;
        $data['survey']['questionnaire_id'] = $data['questionnaire_id'];
        $data['survey']['filled'] = true;

        $updatedsurvey = Survey::where([
            'user_id' => Auth::user()->id,
            'questionnaire_id' => $data['questionnaire_id']
        ])->get();   
        $updatedsurvey[0]->filled = true;
        $updatedsurvey[0]->save();
        
        // $survey = $questionnaire->surveys()->create($data['survey']);
        $updatedsurvey[0]->responses()->createMany($data['responses']);
        
        return redirect(route('questionnaires.index'));
    }

    /**
     * Display a listing of the resource.
     *
     * @param  Questionnaire $questionnaire
     * @return Application|Factory|View
     */
    public function show(Questionnaire $questionnaire){  //widok wypełniania ankiety

        $questionnaire->load('questions.answers');

        return view('questionnaires.fill', compact('questionnaire'));
    }


}
