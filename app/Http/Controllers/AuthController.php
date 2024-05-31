<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function test(){
        User::create([
            'name' => 'Khaled',
            'email' => 'khaled@me.com',
            'password' => Hash::make('123')
        ]);
    }

    public function loginView()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'exists:users'],
            // ,email it was existed above to check the email
            'password' => ['required'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        if (Auth::attempt(array('email' => $request->email, 'password' => $request->password))) {
            return redirect()->route('index');
        } else {
            $validator->errors()->add(
                'password',
                'The password does not match with email'
            );
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }

    public function logout(){
        auth()->logout();
        return redirect()->route('login');
    }

}
