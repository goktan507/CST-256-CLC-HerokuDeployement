<?php
namespace App\Services\Data;

class SecurityDAO
{
    private $servername = "localhost";
    private $username = "root";
    private $password = "root";
    private $database = "cst-256-clc";
    private $connection;
    private $dbQuery;
 
    public function __construct(){
        $this->connection = mysqli_connect($this->servername, $this->username, $this->password, $this->database);
    }
    
    public function getUserProfile($userID){
        $this->dbQuery = "SELECT * FROM `user_info` WHERE `users_id`='$userID'";
        $result = mysqli_query($this->connection, $this->dbQuery);
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
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
        $data = [
            'ID'=>$userID,
            'phonenumber'=>'0000000000',
            'address'=>'N/A',
            'biography'=>'N/A'
        ];
        mysqli_close($this->connection);
        return $data;
    }
    
    public function updateUserProfile($data){
        $userID = $data['userID'];
        $phonenumber = $data['phonenumber'];
        $address = $data['address'];
        $biography = $data['biography'];
        
        $authQuery = "SELECT * FROM `user_info` WHERE `users_id` ='$userID'";
        $result2 = mysqli_query($this->connection, $authQuery);
        $authRow = mysqli_fetch_assoc($result2);
        if($authRow > 0){
            $this->dbQuery = "UPDATE `user_info` SET `phonenumber` = '$phonenumber', `address` = '$address', `biography` = '$biography' WHERE `users_id`='$userID'";
            $result = mysqli_query($this->connection, $this->dbQuery);
            if ($result) {      
                mysqli_close($this->connection);
                return TRUE;
            }
        }
        
//         if user info doesn't exists, create one with empty
        
        $insertQuery = "INSERT INTO `user_info` (`ID`, `phonenumber`, `address` , `biography`, `isAdmin`, `users_id`) VALUES (NULL, '$phonenumber', '$address' , '$biography', '0', '$userID')";
        mysqli_query($this->connection, $insertQuery);
        mysqli_close($this->connection);
        return TRUE;
    }
    
    public function getAllProfiles(){
        $this->dbQuery = "SELECT * FROM `user_info`";
        
        $result = mysqli_query($this->connection, $this->dbQuery);
        $data = [];
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)){
               $userID = $row['users_id'];
               $dbQuery2 = "SELECT * FROM `users` WHERE `id` = '$userID'";
               $result2 = mysqli_query($this->connection, $dbQuery2);
               if(mysqli_num_rows($result2) > 0){
                   $row2 = mysqli_fetch_assoc($result2);
               }
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
                array_push($data, $user); 
            }
            mysqli_free_result($result);
            mysqli_close($this->connection);
            return $data;
        }
        mysqli_close($this->connection);
        return false;
    }
    
    public function editSelectedProfile($userID){
        $this->dbQuery = "SELECT * FROM `user_info` WHERE `users_id` = '$userID'";
        $result = mysqli_query($this->connection, $this->dbQuery);
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $dbQuery2 = "SELECT * FROM `users` WHERE `id` = '$userID'";
            $result2 = mysqli_query($this->connection, $dbQuery2);
            if(mysqli_num_rows($result2) > 0){
                $row2 = mysqli_fetch_assoc($result2);
            }
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
            return $data;
        }
        mysqli_close($this->connection);
        return false;
    }
    
    public function adminUpdateSelectedProfile($data){
        $userID = $data['userID'];
        $name = $data['name'];
        $email = $data['email'];
        $isAdmin = $data['isAdmin'];
        $phonenumber = $data['phonenumber'];
        $address = $data['address'];
        $biography = $data['biography'];
      
        $authQuery = "UPDATE `users` SET `name` = '$name', `email` = '$email' WHERE `id`='$userID'";     
        mysqli_query($this->connection, $authQuery);
        
        $this->dbQuery = "UPDATE `user_info` SET `phonenumber` = '$phonenumber', `address` = '$address', `biography` = '$biography', `isAdmin` = '$isAdmin' WHERE `users_id`='$userID'";
        mysqli_query($this->connection, $this->dbQuery);
        return TRUE;
    }
    
    public function adminSuspendProfile($userID){
        $this->dbQuery = "SELECT * FROM `users` WHERE `id`='$userID'";
        $result = mysqli_query($this->connection, $this->dbQuery);
        $row = mysqli_fetch_assoc($result);
        if ($row > 0) {
            $name=$row['name'];
            $email = $row['email'];
            $email_verified_at = $row['email_verified_at'];
            $password=$row['password'];
            $remember_token = $row['remember_token'];
            $created_at =$row['created_at'];
            $updated_at= $row['updated_at'];

            $suspendQuery = "INSERT INTO `users_suspended` (`id`, `name`,`email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES ('$userID', '$name', '$email', '$email_verified_at', '$password', '$remember_token', '$created_at', '$updated_at')";
            mysqli_query($this->connection, $suspendQuery);
            
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
            $deleteQuery = "DELETE FROM `user_info` WHERE `users_id` = '$userID'";
            $deleteQuery2 = "DELETE FROM `users` WHERE `id` = '$userID'";
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
}

