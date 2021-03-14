<?php

namespace App\Http\Controllers;

use App\Services\Security\SecurityService;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    private $service;
    public function __construct(){
        $this->service =  new SecurityService();    //initializing SecurityService on create of UserController
    }
    
    public function getUserProfile(){
        $userID = Auth::user()->id;     //gets the user ID from Auth
        $data = $this->service->getUserProfile($userID);    //using User ID, get's user's profile passing value to SecurityService
        return view('profile', $data);  //returns to profile page with the user profile information stored in data array
    }
    
    public function updateUserProfile(){
        // creates a data array including user profiles posted from edit profile page
        $data = [
            'userID' => Auth::user()->id,
            'phonenumber' => $_POST['phonenumber'],
            'address' => $_POST['address'],
            'biography' => $_POST['biography']
        ];
        $this->service->updateUserProfile($data);   //sends the posted data to SecurityService update function
        return view('profile', $data);  //returns page with the same data array meaning that update is always succeesful 
    }
    
    public function getAllProfiles(){
        $data = $this->service->getAllProfiles();   //calls the security service to get all profiles to display in admin Module
        return view('adminAllProfiles')->with('data', $data);   //returns to the admin page with all the user information stored in data array
    }
    
    public function editSelectedProfile(){  
        $userID = $_POST['userID'];     //admin function, gets the hidden key userID from the form method post 
        $data = $this->service->editSelectedProfile($userID);       //using the userID, passes the value to security service
        return view('adminEditSelectedProfile')->with('data', $data);   //update is always successful, no validation, returns the same data array
    }
    
    public function adminUpdateSelectedProfile(){
        //creates a data array with all the posted values from admin edit form 
        $data = [
            'userID' => $_POST['userID'],
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'isAdmin' => $_POST['isAdmin'],
            'phonenumber' => $_POST['phonenumber'],
            'address' => $_POST['address'],
            'biography' => $_POST['biography']
        ];
        $this->service->adminUpdateSelectedProfile($data);  //passes all the information stored in data array to security service
        return redirect('get_profiles'); 
    }
    
    public function adminSuspendProfile(){
        $userID = $_POST['userID']; //in order to suspend correct user, gets the user ID from the form as hidden key
        $this->service->adminSuspendProfile($userID);    //passes the userID to security service
        return redirect('get_profiles');     //return to admin module by getting all the active profiles on cite.
    }
    
    public function adminDeleteProfile(){
        $userID = $_POST['userID']; //in order to delete correct user, gets the user ID from the form as hidden key
        $this->service->adminDeleteProfile($userID);    //passes the userID to security service
        return redirect('get_profiles');     //return to admin module by getting all existing and active profiles on cite
    }
    
    public function getPortfolio(){
        $userID = Auth::user()->id;     //gets the current user ID from Auth
        $data = $this->service->getPortfolio($userID);  //passes the userID to security service
        return view('portfolio')->with($data);      //returns to portfolio page with the data storing all information for logged in user
    }
    
    public function updatePortfolio(){
        $userID = Auth::user()->id;     //gets the current userID from Auth
        //creates a data array with all the posted values from portfolio edit form 
        $data = [
            'userID' => $userID,
            'job' => $_POST['job'],
            'skills' => $_POST['skills'],
            'education' => $_POST['education']
        ];
        $this->service->updatePortfolio($data);     //passes the portfolio information stored in data array to security service
        return redirect('get_portfolio');      //return so portfolio page, after getting the updated portfolio
    }
    
    public function adminEditPortfolio(){
        $userID = $_POST['userID'];     // admin module, passes the userID from the form method post, hidden userID key
        $data = $this->service->adminEditPortfolio($userID);     //passes the userID to security service
        return view('adminEditPortfolio')->with('data', $data);     //returns to admin edit form using updated data array storing all information
    }
    
    public function adminUpdatePortfolio(){
        $userID = $_POST['userID'];     // admin module, passes the userID from the form method post, hidden userID key
        //creates a data array with all the posted values from portfolio edit form 
        $data = [
            'userID' => $userID,
            'job' => $_POST['job'],
            'skills' => $_POST['skills'],
            'education' => $_POST['education']
        ];
        $this->service->adminUpdatePortfolio($data);    //passes the portfolio information stored in data array to security service
        return redirect('get_profiles');    //returns to admin module getting all the updated user profiles
    }
    
    public function getAllJobs(){
        $data = $this->service->getAllJobs();   //request all the posted jobs from security service
        return view('jobs')->with('data', $data);   //returns to jobs page using data array storing all the job information for users 
    }
    
    public function deletePortfolio(){
        $userID = $_POST['userID'];     // admin module, passes the userID from the form method post, hidden userID key
        $this->service->deletePortfolio($userID);   //passes the userID to security service
        return redirect('get_jobs');     //returns to job page to see if the the job posting was deleted
    }
    
    public function getAllGroups(){
        $data = $this->service->getAllGroups();     //request all the groups from security service
        return view('groups')->with('data', $data);     //returns to groups view page with the data passed from security service
    }
    
    public function deleteGroup(){
        $groupID = $_POST['groupID'];   //the group id passed from form post to delete specific group
        $this->service->deleteGroup($groupID);  //requests to delete group with groupID being passed to security service
        return redirect('get_groups');  //redirects back to groups view
    }
    
    public function editGroup(){
        $groupID = $_POST['groupID'];       //the group id passed from form post to edit specific group
        $data = $this->service->editGroup($groupID); //requests to get group info with groupID being passed to security service
        return view('editGroup')->with('data', $data);  //returns to editGroup view to display current information of group
    }
    
    public function updateGroup(){
        //storing all the information passed from editGroup view
        $data = [
            'groupID' => $_POST['groupID'],
            'name' => $_POST['name'],
            'description' => $_POST['description']
        ];
        $this->service->updateGroup($data);     //passes the data array storing all information, to pass into security service to update group
        return redirect('get_groups');      //redirects back to the groups view
    }
    
    public function getCreateGroup(){
        return view('createGroup'); //sends to the create group view
    }
    
    public function createGroup(){
        //storing all the information passed from createGroup view
        $data = [
            'name' => $_POST['name'],
            'description' => $_POST['description'],
            'userID' => Auth::user()->id
        ];
        $this->service->createGroup($data); //passes the data array storing all information, to pass into security service to create group
        return redirect('get_groups');  //redirects back to groups view
    }
    
    public function joinGroup(){
        $groupID = $_POST['groupID'];   //the group id passed from form post to join specific group
        $this->service->joinGroup($groupID);    //passes the groupID that user is trying to join
        return redirect('get_groups');   //redirects back to groups view
    }
    
    public function leaveGroup(){
        $groupID = $_POST['groupID'];   //the group id passed from form post to leave specific group
        $this->service->leaveGroup($groupID);     //passes the groupID that user is trying to leave
        return redirect('get_groups');  //redirects back to groups view
    }
    
    public function getJobsBySearch(){
        $search = $_POST['search'];
        $data = $this->service->getJobsBySearch($search);
        if($data == 'getAll'){
            return redirect('/get_jobs');
        }
        return view('jobs')->with('data', $data);
    }
    
    public function viewJob(){
        $data = [
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'job' => $_POST['job'],
            'skills' => $_POST['skills'],
            'education' => $_POST['education']
        ];
        return view('viewJob')->with('data', $data);            
    }
}
