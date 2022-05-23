<?php

namespace App\Http\Controllers;

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
        return view('questionnaires.create');
    }


    // /**
    //  * Create a new Questionnaire
    //  *
    //  * @param  array  $data
    //  * @return \App\Models\Questionnaire
    //  */
    // protected function store(array $data)
    // {
    //     return Questionnaire::create([
    //         'firstname' => $data['firstname'],
    //         'lastname' => $data['lastname'],
    //         'email' => $data['email'],
    //         'password' => Hash::make($data['password']),
    //     ]);
    // }

    /**
     * Store in storage and save a newly created questionnaire.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = request()->validate([
            'title' => 'required|String|max:255',
            'startdate' => 'required|date|before_or_equal:enddate',
            'enddate' => 'required|date|after_or_equal:startdate',
            //tutaj jeszcze podpięci użytkownicy itp. pola
        ]);

        $data['user_id'] = auth()->user()->id;
        $questionnaire = Questionnaire::create($data);
        // $questionnaire = auth()->user()->User::questionnaires()->Questionnaire::create($data);

        // return redirect(route('questionnairesModerator.index')); //przekierowanie do widoku index
        return redirect(route('questionnairesModerator.show', $questionnaire->id)); //przekierowanie do dalszej edycji ankiety i dodawania pytań

        // $data['students_ids']
        // $data['id_ankiety']
    }

    // /**
    //  * Show the form with stats or form for edit questions on the specified questionnaire.
    //  *
    //  * @param  int $id
    //  * @return View
    //  */
    // public function show(int $id)
    // {
    //     $questionnaire = DB::table('questionnaires')->get()->where('id', $id);
    //     $questionnaire->load('questions');

    //     dd($questionnaire);
    //     // dd($id);
    //     return view('questionnaires.show', [
    //         'questionnaireid' => $id 
    //     ]);
    // }

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

        //// Lazy Eager Loading
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
        // $questionnaire = DB::table('questionnaires')->get()->where('id', $id)->first(); //znajduje pierwszy element w tabeli o podanym id
        $questionnaire->load('questions.answers');
        return view('questionnaires.stats', [  //widok ze statystykami
            'questionnaire' => $questionnaire 
        ]);
        // return view('questionnaires.stats', compact('questionnaire'));
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
        // dd($questionnaire[0]);
        return view('questionnaires.edit', [
                'questionnaire' => $questionnaire 
        ]);
    }

    // /**
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  Questionnaire  $questionnaire
    //  * @return View
    //  */
    // public function edit(Questionnaire $questionnaire)
    // { 
    //     // dd($questionnaire);
    //     return view('questionnaires.edit', [
    //             'questionnaire' => $questionnaire 
    //     ]);
    //     // if($stats == 1){
    //     //     dd("mam statystyki");
    //     //     return view('questionnaires.stats', [
    //     //         'questionnaire' => $questionnaire
    //     //     ]);
    //     // }else{
    //     //     dd("NIE mam statystyki");
    //     //     return view('questionnaires.edit', [
    //     //         'questionnaire' => $questionnaire 
    //     //     ]);
    //     // }
        
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateQuestionnaireRequest  $request
     * @param  int  $id
     * @return RedirectResponse
     */
    public function update(Request $request, int  $id)
    // public function update(Questionnaire $questionnaire)
    {
        $request->validate([
            'title' => 'required|String|max:255',
            'startdate' => 'required|date|before_or_equal:enddate',
            'enddate' => 'required|date|after_or_equal:startdate'
        ]);
                
        $new_title = $request->all()['title'];
        $new_startdate = $request->all()['startdate'];
        $new_enddate = $request->all()['enddate'];

        // $updatedquestionnaire = Questionnaire::find($questionnaire->id);
        $updatedquestionnaire = Questionnaire::find($id);

        $updatedquestionnaire->title = $new_title;
        $updatedquestionnaire->startdate = $new_startdate;
        $updatedquestionnaire->enddate = $new_enddate;

        // foreach ($requestData as $key => $val)
        //     $updatedquestionnaire->$key = $val;

        $updatedquestionnaire->save();
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
        //Trzeba usunąć jeszcze wszystkie pytania i odpowiedzi powiązane z questionnaire
        // $questions = $questionnaire->questions()->load();
        // $answers = $questions->questions()->load();

        dd($questionnaire);
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

