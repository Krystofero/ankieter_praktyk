<?php

namespace App\Http\Controllers;

use App\Models\Questionnaire;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

class QuestionnaireController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index() //widok zarządzania własnymi ankietami
    {
        // return view('questionnaires.list',[
        //     'questionnaires' => Questionnaire::all(),   #lista wszystkich ankiet podpiętych do użytkownika zwracana w blade
        // ]);

        if (!(Auth::user()) || Auth::user()->user_level != "Student"){
            return redirect('/');
        }else
            return view('questionnaires.list');

        // return view('users.index', [
        //     'users' => Questionnaire::all(),   #lista użytkowników zwracana w blade    
        //     'users_level_list' => array(1 => 'Administrator', 2 => 'Moderator', 3 => 'Student')  
        // ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = request()->validate([
            // 'title' => 'required',
            // 'startdate' => 'required',
            // 'enddate' => 'required',
            // //tutaj jeszcze podpięci użytkownicy itp. pola
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function fill(){  //widok wypełniania ankiety
        return view('questionnaires.fill');
    }


    // /**
    //  * Display a listing of the resource.
    //  *
    //  * @return Application|Factory|View
    //  */
    // public function manage() //widok zarządzania wszystkimi ankietami
    // {
    //     return view('questionnaires.manage');
    // }

    // /**
    //  * Display a listing of the resource.
    //  *
    //  * @return Application|Factory|View
    //  */
    // public function create(){  //widok tworzenia nowej ankiety
    //     return view('questionnaires.create');
    // }





}
