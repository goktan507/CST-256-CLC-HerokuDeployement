<?php
namespace App\Services\Security;

use App\Services\Data\SecurityDAO;

class SecurityService
{   
    private $dao;
    
    public function __construct(){
        $this->dao = new SecurityDAO();     //initializes the SecurityDAO on create of SecurityService
    }
    
    public function getUserProfile($userID){       
        return $this->dao->getUserProfile($userID); //passes the value to securityDAO
    }
    
    public function updateUserProfile($data){
        return $this->dao->updateUserProfile($data); //passes the value to securityDAO
    }
    
    public function getAllProfiles(){
        return $this->dao->getAllProfiles(); //passes the value to securityDAO
    }
    
    public function editSelectedProfile($userID){
        return $this->dao->editSelectedProfile($userID); //passes the value to securityDAO
    }
    
    public function adminUpdateSelectedProfile($data){      
        return $this->dao->adminUpdateSelectedProfile($data); //passes the value to securityDAO
    }
    
    public function adminSuspendProfile($userID){
        return $this->dao->adminSuspendProfile($userID); //passes the value to securityDAO
    }
    
    public function adminDeleteProfile($userID){
        return $this->dao->adminDeleteProfile($userID); //passes the value to securityDAO
    }
    
    public function getPortfolio($userID){
        return $this->dao->getPortfolio($userID); //passes the value to securityDAO
    }
    
    public function updatePortfolio($data){
        return $this->dao->updatePortfolio($data); //passes the value to securityDAO
    }
    
    public function adminEditPortfolio($userID){
        return $this->dao->getPortfolio($userID); //passes the value to securityDAO
    }
    
    public function adminUpdatePortfolio($data){
        return $this->dao->updatePortfolio($data); //passes the value to securityDAO
    }
    
    public function getAllJobs(){
        return $this->dao->getAllJobs(); //passes the value to securityDAO
    }
    
    public function deletePortfolio($userID){
        return $this->dao->deletePortfolio($userID); //passes the value to securityDAO
    }
    
    public function isAdmin($userID){
        return $this->dao->isAdmin($userID); //passes the value to securityDAO
    }
    
    public function getAllGroups(){
        return $this->dao->getAllGroups();
    }
    
    public function deleteGroup($groupID){
        return $this->dao->deleteGroup($groupID);
    }
    
    public function editGroup($groupID){
        return $this->dao->editGroup($groupID);        
    }
    
    public function updateGroup($data){
        return $this->dao->updateGroup($data);
    }
    
    public function createGroup($data){
        return $this->dao->createGroup($data);
    }
    
    public function joinGroup($groupID){
        return $this->dao->joinGroup($groupID);
    }
    
    public function leaveGroup($groupID){
        return $this->dao->leaveGroup($groupID);
    }
}

