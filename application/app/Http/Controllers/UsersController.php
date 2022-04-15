<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('users.list', [
            'users' => User::all(),   #lista użytkowników zwracana w blade    
            'users_level_list' => array(1 => 'Administrator', 2 => 'Moderator', 3 => 'Student')  
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  User  $user
     * @return View
     */
    public function edit(User $user)
    {
        return view('users.edit', [
            'user' => $user,
            'users_level_list' => array(1 => 'Administrator', 2 => 'Moderator', 3 => 'Student')  
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateUserRequest  $request
     * @param  User  $user
     * @return RedirectResponse
     */
    public function update(Request $request, User $user)
    {
        $new_user_level = $request->all()['user_level'];
        $updatedUser = User::find($user->id);
        $updatedUser->user_level = $new_user_level;
        $updatedUser->save();
        return redirect(route('users.index'))->with('status', __('user.update.success'));
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return JsonResponse
     */
    public function destroy(User $user)
    // public function destroy($id)
    {   
        // $thisuser = User::find($id);
        // $thisuser -> delete();
        // return response()->json([
        //         'status' => 'success'
        //     ]);

        try {
            $user->delete();
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
