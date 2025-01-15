<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    //
    public function register()
    {
        return view('account.register');
        }
        public function processRegister(Request $request){
            $validator =Validator::make($request->all(),[
                'name' => 'required|min:3',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:8|confirmed',
                'password_confirmation' => 'required',
                ]);
                if ($validator->fails()) {
                    return redirect()->route('account.register')->withErrors($validator)->withInput();

        }else{
            $user = new User();
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = Hash::make($request->password);
            $user->save();
            return redirect()->route('account.login')->with('success','User created successfully');


        }
}
public function login()
{
    return view('account.login');
    }
    public function authinticate(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required',
            ]);
            if ($validator->fails()) {
                return redirect()->route('account.login')->withErrors($validator)->withInput();
                }else{
                    $credentials = $request->only('email', 'password');
                    if (Auth::attempt($credentials)) {
                        return redirect()->route('account.profile')->with('success','You are logged in');
                        }else{
                            return redirect()->route('account.login')->with('error','Invalid credentials');
                            }
                            }
                            }
                            public function profile()
                            {
                                $user = User::find(Auth::user()->id); // Retrieve the authenticated user's data
                                return view('account.profile', [
                                    'user' => $user, // Pass the user data to the view
                                ]);
                            }
                            public function updateProfile(Request $request){
                                $validator = Validator::make($request->all(),[
                                    'name' => 'required|min:3',
                                    'email' => 'required|email|unique:users,email,'.Auth::user()->id
                                    ]);
                                    if ($validator->fails()) {
                                        return redirect()->route('account.profile')->withErrors($validator)->withInput();
                                        }else{
                                            $user = User::find(Auth::user()->id);
                                            $user->name = $request->input('name');
                                            $user->email = $request->input('email');
                                            $user->save();
                                            return redirect()->route('account.profile')->with('success','Profile updated successfully');
                                            }



                            }
                            
                            public function logout()
                            {
                                Auth::logout();
                                return redirect()->route('account.login')->with('success','You are logged out');
                                }



}
