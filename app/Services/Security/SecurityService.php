<?php
namespace App\Services\Security;

use App\Services\Data\SecurityDAO;

class SecurityService
{   
    private $dao;
    
    public function __construct(){
        $this->dao = new SecurityDAO();
    }
    
    public function getUserProfile($userID){       
        return $this->dao->getUserProfile($userID);
    }
    
    public function updateUserProfile($data){
        return $this->dao->updateUserProfile($data);
    }
    
    public function getAllProfiles(){
        return $this->dao->getAllProfiles();
    }
    
    public function editSelectedProfile($userID){
        return $this->dao->editSelectedProfile($userID);
    }
    
    public function adminUpdateSelectedProfile($data){
        return $this->dao->adminUpdateSelectedProfile($data);
    }
    
    public function adminSuspendProfile($userID){
        return $this->dao->adminSuspendProfile($userID);
    }
    
    public function adminDeleteProfile($userID){
        return $this->dao->adminDeleteProfile($userID);
    }
}

