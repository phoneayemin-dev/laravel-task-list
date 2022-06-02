<?php

namespace App\Http\Controllers;


use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

use App\Http\Requests\StoreRegisterRequest;
use App\Http\Requests\LoginRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function postRegister(StoreRegisterRequest $request) {

        $validated = $request->validated();

        $newUser = new User();
        $newUser->name = $validated['name'];
        $newUser->email = $validated['email'];
        $newUser->password = bcrypt($validated['password']);
        $newUser->save();

        return view('auth.login');

    }

    public function getRegister(Request $request) {
        return view("auth.register");
    }   

    public function getLogin(Request $request) {
        return view('auth.login');
    }

    public function postLogin(LoginRequest $request) {

        $validated = $request->validated();
        if (Auth::attempt(['email' => $validated['email'], 'password' => $validated['password']])) {
            $user = User::whereId(Auth::id())->first();
            return view("tasks.index", [ 'tasks' => $user->tasks()->get()]);
        }

        return view('auth.login')->with('responseMessage', ["Email and password doesn't match."]);
    }

    public function getLogout(Request $request) {
        Auth::logout();
        return redirect('auth/login');
    }

    public function getResetPassword(Request $request) {
        return view('auth.passwords.reset');
    }
    public function getEmail(Request $request) {
        return view('auth.passwords.email');
    }

    public function postEmail(Request $request) {
        $request->validate([
            'email' => 'required|email'
        ]);
        $token = Str::random(64);
        DB::table('password_resets')->insert([
            'email' =>$request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        // $resetLink = route("reset-password/{token}", [ 
        //     'token' => $token,
        //     'email' => $request->email
        // ]);

        // $body = "We have received to reset password for <strong> Laravel Task List </strong> app with ". $request->email. ". You can reset by clickiing the link below.";
    
        Mail::send("auth.emails.password", ['token' => $token, 'email' => $request->email ], function($message) use($request){
            $message->from('noreply@example.com', 'Laravel Task List');
            $message->to($request->email, "User");
            $message->subject('Reset Password');
        });

        return back()->with('success', 'We e-mailed your password reset link');
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
