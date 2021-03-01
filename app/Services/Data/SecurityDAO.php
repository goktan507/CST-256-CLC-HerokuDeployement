<?php
namespace App\Services\Data;

use Illuminate\Support\Facades\Auth;

class SecurityDAO
{
    private $servername = "hwr4wkxs079mtb19.cbetxkdyhwsb.us-east-1.rds.amazonaws.com";          //All the 
    private $username = "r19b09ea1f2iz1p8";                 //         data credentials
    private $password = "zqb3ezhiq4qxe1dx";                 //                          set in a private global 
    private $database = "jhh3kvw8ugp8fuka";          //                                                  variable to be used in connection
    private $connection;                    
    private $dbQuery;
 
    public function __construct(){       //connection is set on create of SecurityDAO
        $this->connection = mysqli_connect($this->servername, $this->username, $this->password, $this->database);  
    }
    
    public function getUserProfile($userID){
        $this->dbQuery = "SELECT * FROM `user_info` WHERE `users_id`='$userID'";     //sql script gets user profile related to specific userID
        $result = mysqli_query($this->connection, $this->dbQuery);      
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            //gets the data from database and sets the variables in data array
            $data = [
                'ID'=>$userID, 
                'phonenumber'=>$row['phonenumber'],
                'address'=>$row['address'],
                'biography'=>$row['biography']
            ];
            mysqli_free_result($result);
            mysqli_close($this->connection);
            return $data;
        }
        //if user doesn't have a profile created yet, creates a blank one
        $data = [
            'ID'=>$userID,
            'phonenumber'=>'0000000000',
            'address'=>'N/A',
            'biography'=>'N/A'
        ];
        mysqli_close($this->connection);
        return $data;       //returns the profile information stored in data array
    }
    
    public function updateUserProfile($data){
        // to use in sql script, assigning each variable passed in data array into separate variables.
        $userID = $data['userID'];
        $phonenumber = $data['phonenumber'];
        $address = $data['address'];
        $biography = $data['biography'];
        
        $authQuery = "SELECT * FROM `user_info` WHERE `users_id` ='$userID'";   //sql script checks if the user has user info created
        $result2 = mysqli_query($this->connection, $authQuery);
        $authRow = mysqli_fetch_assoc($result2);
        if($authRow > 0){
            // if user info exists, updates with the updated information
            $this->dbQuery = "UPDATE `user_info` SET `phonenumber` = '$phonenumber', `address` = '$address', `biography` = '$biography' WHERE `users_id`='$userID'";
            $result = mysqli_query($this->connection, $this->dbQuery);
            if ($result) {      
                mysqli_close($this->connection);
                return TRUE;
            }
        }
        
//         if user info doesn't exist, creates one with empty
        
        $insertQuery = "INSERT INTO `user_info` (`ID`, `phonenumber`, `address` , `biography`, `isAdmin`, `users_id`) VALUES (NULL, '$phonenumber', '$address' , '$biography', '0', '$userID')";
        mysqli_query($this->connection, $insertQuery);
        mysqli_close($this->connection);
        return TRUE;
    }
    
    /*
     * user profile has 2 separate parts, one has login credentials, other has personal information-
     * -such us isAdmin, phone number, biography, address.
     */
    public function getAllProfiles(){
        $this->dbQuery = "SELECT * FROM `user_info`";   //sql script gets all user's profiles
        
        $result = mysqli_query($this->connection, $this->dbQuery);
        $data = [];
        if (mysqli_num_rows($result) > 0) {     //if there are at least one user profile created in database pulls all the profile from rows
            while($row = mysqli_fetch_assoc($result)){
               $userID = $row['users_id'];
               $dbQuery2 = "SELECT * FROM `users` WHERE `id` = '$userID'";  //second sql that gets the login credentials from database
               $result2 = mysqli_query($this->connection, $dbQuery2);
               if(mysqli_num_rows($result2) > 0){
                   $row2 = mysqli_fetch_assoc($result2);
               }
               //putting all login credentials and other user profile information into a user array
               $user = [
                   'userID' => $userID,
                   'name' => $row2['name'],
                   'email' => $row2['email'],
                   'password' => $row2['password'],
                   'phonenumber'=>$row['phonenumber'],
                   'address'=>$row['address'],
                   'biography'=>$row['biography'],
                   'isAdmin' =>$row['isAdmin']
                ];
                array_push($data, $user);   // adding each user profile information to data array to be passed
            }
            mysqli_free_result($result);
            mysqli_close($this->connection);
            return $data;   //returns all the users' profiles stored in data array
        }
        mysqli_close($this->connection);
        return false;
    }
    
    public function editSelectedProfile($userID){
        $this->dbQuery = "SELECT * FROM `user_info` WHERE `users_id` = '$userID'";  //sql script that gets user profile related to specific user
        $result = mysqli_query($this->connection, $this->dbQuery);
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $dbQuery2 = "SELECT * FROM `users` WHERE `id` = '$userID'";
            $result2 = mysqli_query($this->connection, $dbQuery2);
            if(mysqli_num_rows($result2) > 0){
                $row2 = mysqli_fetch_assoc($result2);
            }
            //adds all the user profile information to data array to be passed
            $data = [
                'userID' => $userID,
                'name' => $row2['name'],
                'email' => $row2['email'],
                'password' => $row2['password'],
                'phonenumber'=>$row['phonenumber'],
                'address'=>$row['address'],
                'biography'=>$row['biography'],
                'isAdmin' =>$row['isAdmin']
            ];
            mysqli_free_result($result);
            mysqli_close($this->connection);
            return $data;   //passes all the user profile information stored in data array
        }
        mysqli_close($this->connection);
        return false;
    }
    
    public function adminUpdateSelectedProfile($data){
        // to use in sql script, assigning each variable passed in data array into separate variables.
        $userID = $data['userID'];
        $name = $data['name'];
        $email = $data['email'];
        $isAdmin = $data['isAdmin'];
        $phonenumber = $data['phonenumber'];
        $address = $data['address'];
        $biography = $data['biography'];
      
        //since user profile has 2 parts, updates the login credentials with this sql script
        $authQuery = "UPDATE `users` SET `name` = '$name', `email` = '$email' WHERE `id`='$userID'";    
        mysqli_query($this->connection, $authQuery);
        
        //the second part of the user profile, updates all the personal information in user info table
        $this->dbQuery = "UPDATE `user_info` SET `phonenumber` = '$phonenumber', `address` = '$address', `biography` = '$biography', `isAdmin` = '$isAdmin' WHERE `users_id`='$userID'";
        mysqli_query($this->connection, $this->dbQuery);
        return TRUE;    // always updates no validation required, 
    }
    
    public function adminSuspendProfile($userID){
        $this->dbQuery = "SELECT * FROM `users` WHERE `id`='$userID'";  //sql script gets user related to userID
        $result = mysqli_query($this->connection, $this->dbQuery);
        $row = mysqli_fetch_assoc($result);
        if ($row > 0) {
            //in suspend, we are copying all the information from users table into users_suspended therefore -
            // -user is no longer be able to login without losing user information 
            $name=$row['name'];
            $email = $row['email'];
            $email_verified_at = $row['email_verified_at'];
            $password=$row['password'];
            $remember_token = $row['remember_token'];
            $created_at =$row['created_at'];
            $updated_at= $row['updated_at'];

            $suspendQuery = "INSERT INTO `users_suspended` (`id`, `name`,`email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES ('$userID', '$name', '$email', '$email_verified_at', '$password', '$remember_token', '$created_at', '$updated_at')";
            mysqli_query($this->connection, $suspendQuery);
            
            //second part of the user info (personal info) is stored in user_info which is related to users, on delete both will be deleted
            //therefore we need to copy all the user info into user_suspended_info
            $this->dbQuery = "SELECT * FROM `user_info` WHERE `users_id`='$userID'";
            $result = mysqli_query($this->connection, $this->dbQuery);
            $row = mysqli_fetch_assoc($result);
            if($row > 0){
                $infoID = $row['ID'];
                $phonenumber = $row['phonenumber'];
                $address = $row['address'];
                $biography = $row['biography'];
                $isAdmin = $row['isAdmin'];
                $suspendQuery2 = "INSERT INTO `user_suspended_info`(`ID`, `phonenumber`, `address`, `biography`, `isAdmin`) VALUES ('$infoID','$phonenumber','$address',$biography,'$isAdmin')";
                mysqli_query($this->connection, $suspendQuery2);
            }
            
            // deleting the bound first from user_info, then the actual user
            $deleteQuery = "DELETE FROM `user_info` WHERE `users_id` = '$userID'";  // when all info are saved into suspended tables
            $deleteQuery2 = "DELETE FROM `users` WHERE `id` = '$userID'";           // delete user info and user  
            mysqli_query($this->connection, $deleteQuery);
            mysqli_query($this->connection, $deleteQuery2);
            
            mysqli_free_result($result);
            return TRUE;
        }
        return FALSE;
    }
    
    public function adminDeleteProfile($userID){
            // deleting the bound first from user_info, then the actual user
            $deleteQuery = "DELETE FROM `user_info` WHERE `users_id` = '$userID'";
            $deleteQuery2 = "DELETE FROM `users` WHERE `id` = '$userID'";
            mysqli_query($this->connection, $deleteQuery);
            mysqli_query($this->connection, $deleteQuery2);
            
            return TRUE;
    }
    
    public function getPortfolio($userID){
        $this->dbQuery = "SELECT * FROM `portfolio` WHERE `users_id`='$userID'";    //sql script that gets the user portfolio related to userID
        $result = mysqli_query($this->connection, $this->dbQuery);
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            //creates a data array to store all the user portfolio information
            $data = [
                'userID'=>$userID,
                'job'=>$row['job'],
                'skills'=>$row['skills'],
                'education'=>$row['education']
            ];
            mysqli_free_result($result);
            mysqli_close($this->connection);
            return $data;   //returns the all user portfolio information stored in data array
        }
        //if user doesn't have a portfolio created yet, returns empty values to form
        $data = [
            'userID'=>$userID,
            'job'=>'',
            'skills'=>'',
            'education'=>''
        ];
        mysqli_close($this->connection);
        return $data;   //returns portfolio information stored in data array
    }

    public function updatePortfolio($data){
        // to use in sql script, assigning each variable passed in data array into separate variables.
        $userID = $data['userID'];
        $job = $data['job'];
        $skills = $data['skills'];
        $education = $data['education'];
        
        $this->dbQuery = "SELECT * FROM `portfolio` WHERE `users_id` ='$userID'";   //sql script gets portfolio information related to userID
        $result = mysqli_query($this->connection, $this->dbQuery);
        $row = mysqli_fetch_assoc($result);
        if($row > 0){
            // sql script updates the portfolio user related to userID, using all the information passed from the form in data array
            $this->dbQuery = "UPDATE `portfolio` SET `job` = '$job', `skills` = '$skills', `education` = '$education' WHERE `users_id`='$userID'";
            $result = mysqli_query($this->connection, $this->dbQuery);
            if ($result) {
                return TRUE;    //update is always true, no validation required
            }
        }
        
        //         if user portfolio doesn't exist, creates one with values passed in data array
        
        $insertQuery = "INSERT INTO `portfolio` (`id`, `job`, `skills`, `education` , `users_id`) VALUES (NULL, '$job', '$skills', '$education', '$userID')";
        mysqli_query($this->connection, $insertQuery);
        return TRUE;    // update is always true, no validation required.
    }
    
    public function getAllJobs(){
        $this->dbQuery = "SELECT * FROM `portfolio`";   //sql script that gets all the user portfolios 
        
        $result = mysqli_query($this->connection, $this->dbQuery);
        $data = [];
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)){
                $userID = $row['users_id'];
                $dbQuery2 = "SELECT * FROM `users` WHERE `id` = '$userID'"; // to display user profile info, gets information from different table
                $result2 = mysqli_query($this->connection, $dbQuery2);
                if(mysqli_num_rows($result2) > 0){
                    $row2 = mysqli_fetch_assoc($result2);
                }
                //creates a user array to store all neccessary information 
                $user = [
                    'userID' => $userID,
                    'name' => $row2['name'],
                    'email' => $row2['email'],
                    'job' => $row['job'],
                    'skills' => $row['skills'],
                    'education' => $row['education']
                ];
                array_push($data, $user);   //puts user array into a data array that will store all user and its portfolio
            }
            mysqli_free_result($result);
            mysqli_close($this->connection);
            return $data; //returns all users' portfolios stored in data array
        }
        mysqli_close($this->connection);
        return false;
    }
    
    public function deletePortfolio($userID){
        $deleteQuery = "DELETE FROM `portfolio` WHERE `users_id` = '$userID'";  //sql script that deletes job postings (portfolio)
        mysqli_query($this->connection, $deleteQuery);
        return TRUE;
    }
    
    public function isAdmin($userID){
        $this->dbQuery = "SELECT * FROM `user_info` WHERE `users_id`='$userID'";    //sql script that gets the information from user_info related to userID
        $result = mysqli_query($this->connection, $this->dbQuery);
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result); 
            $isAdmin = $row['isAdmin'];     //gets the isAdmin property to be passed.
            mysqli_free_result($result);
            mysqli_close($this->connection);
            return $isAdmin;    //passes the isAdmin value either 1 (true-> admin) or 0 (false-> normal user)
        }
    }
    
    public function getAllGroups(){
        $this->dbQuery = "SELECT * FROM `groups`";     //sql script gets all groups
        $result = mysqli_query($this->connection, $this->dbQuery);
        $data = [];
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)){
                $groupID = $row['id']; 
                $members = $this->getGroupMembers($groupID);
                $dbQuery2 = "SELECT * FROM `membership` WHERE `groups_id` = '$groupID'"; // to display members, gets information from different table
                $result2 = mysqli_query($this->connection, $dbQuery2);
                if(mysqli_num_rows($result2) > 0){
                    $userID = $row['users_id'];
                }
                $dbQuery3 = "SELECT * FROM `users` WHERE `id` = '$userID'"; // to display the owner, gets information from different table
                $result3 = mysqli_query($this->connection, $dbQuery3);
	$row3;                
if(mysqli_num_rows($result3) > 0){
                    $row3 = mysqli_fetch_assoc($result3);
                }
                //creates a group array to store all neccessary information
                $group = [
                    'groupID' => $groupID,
                    'name' => $row['name'],
                    'description' => $row['description'],
                    'userID' => $userID,
                    'owner' => $row3['name'],
                    'members' => $members
                ];
                array_push($data, $group);   //puts group array into a data array that will store all group infos 
            }
            mysqli_free_result($result);
            mysqli_close($this->connection);
            return $data; //returns all groups stored in data array
        }
        mysqli_close($this->connection);
        return false;
    }
    
    public function getGroupMembers($groupID){
        $membersQuery = "SELECT * FROM `membership` WHERE `groups_id` = '$groupID'";      // sql script gets members of specific group using groupID
        $result = mysqli_query($this->connection, $membersQuery);
        $members = [];      //array that stores all the members' names
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){  //while loop to get every user id that are joined to same group
                $userID = $row['users_id'];
                $usersQuery = "SELECT * FROM `users` WHERE `id` = '$userID'";      //sql script gets user name using userID found above 
                $result2 = mysqli_query($this->connection, $usersQuery);
                if($row2 = mysqli_fetch_assoc($result2)){
                    array_push($members, $row2['name']);        //puts the name of the user into members array to be returned
                }
            }
        }
        return $members;    //returns the members of the group
    }
    
    public function deleteGroup($groupID){
        $deleteQuery = "DELETE FROM `groups` WHERE `id` = '$groupID'";  //sql script that deletes group (within the members of its being created as one-to-many relation
        mysqli_query($this->connection, $deleteQuery);                  //that has a relationship of cascade on delete or on update
        return TRUE;
    }
    
    public function editGroup($groupID){
        $this->dbQuery = "SELECT * FROM `groups` WHERE `id`='$groupID'";    //sql script that gets the group related to groupID
        $result = mysqli_query($this->connection, $this->dbQuery);
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            //creates a data array to store all the group information
            $data = [
                'groupID'=>$groupID,
                'name'=>$row['name'],
                'description'=>$row['description']
            ];
            mysqli_free_result($result);
            mysqli_close($this->connection);
            return $data;   //returns the all group information stored in data array
        }
    }
    
    public function updateGroup($data){
        // to use in sql script, assigning each variable passed in data array into separate variables.
        $groupID = $data['groupID'];
        $name = $data['name'];
        $description = $data['description'];
        
        // sql script updates the group related to groupID, using all the information passed from the form in data array
        $this->dbQuery = "UPDATE `groups` SET `name` = '$name', `description` = '$description' WHERE `id`='$groupID'";
        $result = mysqli_query($this->connection, $this->dbQuery);
        if ($result) {
            return TRUE;    //update is always true, no validation required
        }
        return FALSE;   //if connection or query gives error, returns false
    }
    
    public function createGroup($data){
        // to use in sql script, assigning each variable passed in data array into separate variables.
        $name = $data['name'];
        $description = $data['description'];
        $userID = $data['userID'];
        //sql script to insert (create) a groups table using passed variables 
        $insertQuery = "INSERT INTO `groups` (`id`, `name`, `description`, `users_id`) VALUES (NULL, '$name', '$description', '$userID')";
        if(mysqli_query($this->connection, $insertQuery))
            return TRUE;    // create is always true, no validation required.
       return false;    //if connection or query gives error, returns false
    }
    
    public function joinGroup($groupID){
        $userID = Auth::user()->id; //gets the user id that is logged in (the user performs join to group is the one that is logged in)
        $insertQuery = "INSERT INTO `membership` (`id`, `groups_id`, `users_id`) VALUES (NULL, '$groupID', '$userID')";     //sql script that inserts a new membership for groups
        mysqli_query($this->connection, $insertQuery);                                                                      //that has user id and group id meaning that user has
        return TRUE;    // create is always true, no validation required.                                                   //joined the the group that has id of groupID
    }
    
    public function leaveGroup($groupID){
        $userID = Auth::user()->id; //gets the user id that is logged in (the user performs leave to group is the one that is logged in)
        $deleteQuery = "DELETE FROM `membership` WHERE `groups_id` = '$groupID' AND `users_id` = '$userID'";  //sql script that deletes membership that provides
        mysqli_query($this->connection, $deleteQuery);                                                        //user id and group id, by deleting the membership
        return TRUE;   // create is always true, no validation required.                                      //we destroy the relationship between user and group
    }
}

