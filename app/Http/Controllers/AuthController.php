<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function postRegister(Request $request) {

        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'password' => 'required|min:4',
            'email' => 'required|email|unique:users',
            'password_confirmation' => 'required_with:password|same:password|min:4'
        ]);

        if ($validator->fails())
        {
            $messages = $validator->getMessageBag();
            return view("auth.register", ['errors' => $messages]);
        }

        $newUser = new User();
        $newUser->name = $request->name;
        $newUser->email = $request->email;
        $newUser->password = bcrypt($request->password);
        $newUser->save();

        return view('welcome');

    }

    public function getRegister(Request $request) {
        return view("auth.register");
    }   

    public function getLogin(Request $request) {
        return view('auth.login');
    }

    public function postLogin(Request $request) {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:4'
        ]);

        $messages = collect();
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return view('auth.login', ['errors' => $messages]);
        }
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = User::whereId(Auth::id())->first();
            return view("tasks.index", [ 'tasks' => $user->tasks()->get()]);
        }

        return redirect('login');
    }

    public function getLogout(Request $request) {
        Auth::logout();
        return view('welcome');
    }
    public function index()
    {
        //
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
