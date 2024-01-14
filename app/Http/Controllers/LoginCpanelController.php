<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginCpanelController extends Controller
{

    public function cpanel_login()
    {
        return view('login');
    }

    public function cpanel_login_proses(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()){
            return response()->json([
                    "status" => false,
                    "errors" => $validator->errors()
                ]);
        } else {
            if (Auth::attempt($request->only(["email", "password"]))) {
                return response()->json([
                    "status" => true,
                    "redirect" => url("Home")
                ]);
            } else {

                return response()->json([
                    "status" => false,
                    "errors" => ["Invalid credentials"]
                ]);
            }
        }
    }



    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}

