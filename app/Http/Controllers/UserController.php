<?php

namespace App\Http\Controllers;

use App\Services\Security\SecurityService;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    private $service;
    public function __construct(){
        $this->service =  new SecurityService();
    }
    
    public function getUserProfile(){
        $userID = Auth::user()->id;
        $data = $this->service->getUserProfile($userID);
        return view('profile', $data);
    }
    
    public function updateUserProfile(){
        $data = [
            'userID' => Auth::user()->id,
            'phonenumber' => $_POST['phonenumber'],
            'address' => $_POST['address'],
            'biography' => $_POST['biography']
        ];
        $this->service->updateUserProfile($data);
        return view('profile', $data);
    }
    
    public function getAllProfiles(){
        $data = $this->service->getAllProfiles();
        return view('adminAllProfiles')->with('data', $data);
    }
    
    public function editSelectedProfile(){
        $userID = $_POST['userID'];
        $data = $this->service->editSelectedProfile($userID);
        return view('adminEditSelectedProfile')->with('data', $data);
    }
    
    public function adminUpdateSelectedProfile(){
        $data = [
            'userID' => $_POST['userID'],
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'isAdmin' => $_POST['isAdmin'],
            'phonenumber' => $_POST['phonenumber'],
            'address' => $_POST['address'],
            'biography' => $_POST['biography']
        ];
        $this->service->adminUpdateSelectedProfile($data);
        return $this->getAllProfiles();
    }
    
    public function adminSuspendProfile(){
        $userID = $_POST['userID'];
        $this->service->adminSuspendProfile($userID);
        return $this->getAllProfiles();
    }
    
    public function adminDeleteProfile(){
        $userID = $_POST['userID'];
        $this->service->adminDeleteProfile($userID);
        return $this->getAllProfiles();
    }
}
