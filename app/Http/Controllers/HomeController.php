<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $auth = auth()->user();
        if ($auth) {
            if(auth()->user()->hasRole('Super-Admin')){
                return $this->home_superadmin();
            }
            elseif (auth()->user()->hasRole('Admin')) {
                return $this->home_admin();
            }
            else {
                return $this->home_employee();
            }
        }

        return redirect()->intended('Cpanel/Login');
    }

    public function home_superadmin()
    {
        return view('dashboard.home_superadmin');
    }

    public function home_admin()
    {
        return view('dashboard.home_admin');
    }

    public function home_employee()
    {
        return view('dashboard.home_employee');
    }
}
