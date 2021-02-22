<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Services\Security\SecurityService;

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
        //if session is already started, avoid to start again
        if(session_status() != PHP_SESSION_ACTIVE){
            session_start();
        }
        $isAdmin = $this->isAdmin();  //checks to see if user is admin
        if($isAdmin == 1)
            $_SESSION['admin'] = true;
        else
            $_SESSION['admin'] = false;
        //starts a session to set admin status either true or false, then return to home page
        return view('home');
    }

    public function isAdmin(){
        $service = new SecurityService();
        $userID = Auth::user()->id; //gets the user ID
        //within using user ID, goes through SecurityService to SecurityDAO, and
        //to get the isAdmin row and it's value either 1(true) or 0(false) 
        return $service->isAdmin($userID);  
    }
}
