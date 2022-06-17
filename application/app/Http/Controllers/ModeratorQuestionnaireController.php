<?php

namespace App\Http\Controllers;

use Chartisan\PHP\Chartisan;
// use App\Charts\AnswersChart;
use App\Models\Survey;
use App\Models\Questionnaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\JsonResponse;
use Exception;

class ModeratorQuestionnaireController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() //widok zarządzania ankietami moderatora
    {
        if (!(Auth::user()) || Auth::user()->user_level != "Moderator"){
            return redirect('/');
        }else {
            $questionnaires = DB::table('questionnaires')->get()->where('user_id', Auth::user()->id); //pobiera tylko ankiety danego moderatora
            return view('questionnaires.manage',[
                'questionnaires' => $questionnaires,   #lista wszystkich ankiet zarządzanych przez użytkownika zwracana w blade
            ]);
            // return view('questionnaires.manage',[
            //     'questionnaires' => Questionnaire::all()->where('user_id', Auth::user()->id),   #lista wszystkich ankiet zarządzanych przez użytkownika zwracana w blade
            // ]);
        }
            
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $students = DB::table('users')->get()->where('user_level', 'Student');
        return view('questionnaires.create', [
            'students' => $students   #lista wszystkich studentów zwracana w blade    
        ]);
    }

    /**
     * Store in storage and save a newly created questionnaire.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = request()->validate([
            'title' => 'required|String|max:150',
            'description' => 'nullable|String|max:255',
            'startdate' => 'required|date|before_or_equal:enddate',
            'enddate' => 'required|date|after_or_equal:startdate'
        ]);

        $data['user_id'] = auth()->user()->id;
        $questionnaire = Questionnaire::create($data);
        // $questionnaire = auth()->user()->User::questionnaires()->Questionnaire::create($data);

        $data_survey = request()->validate([
            'pinstudents' => 'required'
        ]);
        foreach($data_survey['pinstudents'] as $student){
            $data2['questionnaire_id'] = $questionnaire->id;
            $data2['user_id'] = $student;
            $data2['filled'] = false;
            $survey = Survey::create($data2);
        }
        
        return redirect(route('questionnairesModerator.show', $questionnaire->id)); //przekierowanie do dalszej edycji ankiety i dodawania pytań
    }

    /**
     * Show the form with stats or form for edit questions on the specified questionnaire.
     *
     * @param  Questionnaire $questionnaire
     * @return View
     */
    public function show(Questionnaire $questionnaire)
    {
        // $questions = DB::table('questions')->get()->where('questionnaire_id', 16);
        // $answers = DB::table('answers')->get()->where('question_id', $questions->id);

        //// Lazy Eager Loading - ładowanie dynamiczne "z opóźnieniem"
        $questionnaire->load('questions.answers');

        return view('questionnaires.show', compact('questionnaire'));
    }

    /**
     * Show the form with statistics of the specified resource.
     *
     * @param  Questionnaire  $questionnaire
     * @return View
     */
    public function stats(Questionnaire $questionnaire)
    {
        $questionnaire->load('questions.answers.responses');
        $alphas = range('a', 'z'); //lista małych liter
        // $questionnaire = DB::table('questionnaires')->get()->where('id', $id)->first(); //znajduje pierwszy element w tabeli o podanym id
        // $questionnaire->load('questions.answers');
        // return view('questionnaires.stats', [  //widok ze statystykami
        //     'questionnaire' => $questionnaire 
        // ]);

        $answers_chart = array();
        $numberofquestions = $questionnaire->questions->count();
        for ($i = 0; $i < $numberofquestions; $i++){
            $answers_chart[$i] = null;
        }

        //inicjalizacja zmiennych:
        $letters = array();
        $answers = array();
        $iter = 0;
        $iter2 = 0;
        foreach($questionnaire->questions as $question){
            // if($question->type == "Zamkniete" && $question->responses->count()){
                foreach($question->answers as $answer){
                    // dd($answer);
                    if($question->responses->count()){
                        $answers[$iter] = intval(($answer->responses->count() * 100) / $question->responses->count());
                    }
                    else {
                        $answers[$iter] = 0;
                    }
                    $letters[$iter] = $alphas[$iter];
                    $iter++;
                }
                $answers_chart[$iter2] = Chartisan::build()
                    ->labels($letters)
                    ->dataset('Odpowiedź', $answers)
                    ->toJSON();
                //czyszczenie zmiennych przed nowym obiegiem pętli
                $letters = array();
                $answers = array();

                $iter = 0;   
                $iter2 ++; 
            // }
        }
        // $answers_chart[0] = Chartisan::build()
        // ->labels(['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h'])
        // ->dataset('Odpowiedź', [1, 2, 3, 5, 6, 7, 8, 10])
        // ->toJSON();

        // return view('questionnaires.stats', compact('questionnaire'));
        return view('questionnaires.stats', compact('questionnaire', 'answers_chart', 'alphas'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return View
     */
    public function edit(int $id)
    { 
        $questionnaire = DB::table('questionnaires')->get()->where('id', $id)->first(); //znajduje pierwszy element w tabeli o podanym id
        $pinedstudents = DB::table('surveys')->get()->where('questionnaire_id', $id);
        $students = DB::table('users')->get()->where('user_level', 'Student');        
        return view('questionnaires.edit', [
                'questionnaire' => $questionnaire,
                'students' => $students,
                'pinedstudents' => $pinedstudents
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateQuestionnaireRequest  $request
     * @param  int  $id
     * @return RedirectResponse
     */
    public function update(Request $request, int  $id)
    {
        $request->validate([
            'title' => 'required|String|max:150',
            'description' => 'nullable|String|max:255',
            'startdate' => 'required|date|before_or_equal:enddate',
            'enddate' => 'required|date|after_or_equal:startdate'
        ]);
                
        $new_title = $request->all()['title'];
        $new_description = $request->all()['description'];
        $new_startdate = $request->all()['startdate'];
        $new_enddate = $request->all()['enddate'];

        $updatedquestionnaire = Questionnaire::find($id);

        $updatedquestionnaire->title = $new_title;
        $updatedquestionnaire->description = $new_description;
        $updatedquestionnaire->startdate = $new_startdate;
        $updatedquestionnaire->enddate = $new_enddate;

        // foreach ($requestData as $key => $val)
        //     $updatedquestionnaire->$key = $val;

        $updatedquestionnaire->save();

        $request2 = request()->validate([
            'pinstudents' => 'required'
        ]);
        $pinedstudents = DB::table('surveys')->get()->where('questionnaire_id', $id);
        foreach($request2 as $student){
            foreach($pinedstudents as $student2){
                if($student2->user_id != $student[0]){
                    $data2['questionnaire_id'] = $id;
                    $data2['user_id'] = $student[0];
                    $data2['filled'] = false;
                    $survey = Survey::create($data2);
                }
            }
        }
        return redirect(route('questionnairesModerator.index'))->with('status', __('questionnaires.update.success'));
    }

  /**
     * Remove the specified resource from storage.
     *
     * @param Questionnaire  $questionnaire
     * @return JsonResponse
     */
    public function destroy(Questionnaire  $questionnaire)
    {   
        try {
            $questionnaire->delete();
            return response()->json([
                'status' => 'success'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Wystąpił błąd!'
            ])->setStatusCode(500);
        }
    }
}

