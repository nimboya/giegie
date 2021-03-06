<?php
/*
@ Author: Ewere Diagboya
@ Date: 08-01-2016
@ Time: 4:00pm
@ Location: Ajah, Lagos
@ Project: RateMyProfessor
*/
class User {
// User
  /*
  @params
	- $username
	- $password
  */
  public static function Login($loginparams) {
	$db = Utility::mysqlRes();
	$response = array();
	$errors = array();
   
	// Input Validation
	$email = isset($loginparams['email']) ? $loginparams['email'] : null;
	$password = isset($loginparams['password']) ? $loginparams['password'] : null;
	
	if(!filter_var(trim($email), FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email is not valid!";
	}
	
	if(strlen(trim($password)) === 0) {
        $errors[] = "Please enter password!";
	}
	
	if(empty($errors)) {
		$login = $db->students()->where("email",$loginparams['email'])->where("password",$loginparams['password']);
		
		if($login->count()) {
			$response = array('error_code'=>0,'status'=>'success','description'=>"Login Successful");
		} else {
			$response = array('error_code'=>1,'status'=>'failed','description'=>"Invalid Login Details");
		}
	} else {
		$errors = implode(",", $errors);
		$response = array('error_code'=>1,'status'=>'failed','description'=>$errors);
	}
	return $response;
  }
  
  public static function SocialLogin($params) {
	 $regresp = self::StuRegister($params);
	 $regres = json_decode($regresp);
	 if($regres->status == "ok") {
		session_start();
		$_SESSION['activeuser'] = $params['email'];
		$response = array('error_code'=>0,'status'=>'success','description'=>"Login Successful");
	 }
	 else if(strstr($regres->description,"Email Already Used")) {
		session_start();
		$_SESSION['activeuser'] = $params['email'];
		$response = array('error_code'=>0,'status'=>'success','description'=>"Login Successful");
	 }
	 return $response;
  }  
	  

  public static function Forgot($forgotparams) {
	$db = Utility::mysqlRes();
	$response = array();
	$errors = array();
	
	if(!filter_var($forgotparams['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email is not valid!";
	}
	// Check Mail Existence
	if(self::EmailExists($forgotparams['email']) == true) {
		$errors[] = "Email Does Not Exist";
	}
	
	if(empty($errors)) {
		$student = $db->students()->where("email",$forgotparams['email']);
		if($student->count()) {			
			// Send a New Password
			$newpassword = "RMP".mt_rand(10000000,99999999);
			$data = array("email"=>$forgotparams['email'],"password"=>$newpassword);
			$student->update($data);
			mail($forgotparams['email'],"Your new password","Dear user, your new password is: $newpassword, <p>Thank you for using RateMyLectuers");
			$response = array('error_code'=>0,'status'=>'ok','description'=>'Password Changed Successfully');
		}
		else {
			$errors = implode(",",$errors);
			$response = array('error_code'=>1,'status'=>'failed','description'=>$errors);
		}
	} else {
		$errors = implode(",",$errors);
		$response = array('error_code'=>1,'status'=>'failed','description'=>$errors);
	}
	return $response;
  }
  
  public static function ChangePassword($chparams) {
	$db = Utility::mysqlRes();
	$response = array();
	$errors = array();
	
	$oldpass = isset($chparams['oldpass']) ? $chparams['oldpass'] : null;
	$newpass = isset($chparams['newpass']) ? $chparams['newpass'] : null;
	$rnewpass = isset($chparams['rnewpass']) ? $chparams['rnewpass'] : null;
	
	if(strlen(trim($oldpass)) === 0){
        $errors[] = "Please enter your old password.";
	}
	
	if(strlen(trim($oldpass)) < 6){
        $errors[] = "Password must be greater than 5 characters.";
	}
	
	if(strlen(trim($newpass)) === 0){
        $errors[] = "Please enter your new password.";
	}
	
	if(strlen(trim($rnewpass)) === 0){
        $errors[] = "Please enter your new password again.";
	}
	
	if(trim($rnewpass) || trim($oldpass)) {
		$errors[] = "Your new password does not match.";
	}
	
	if(empty($errors)) {
		$loginparams = array('email'=>$chparams['email'],'password'=>$oldpass);
		$loginresp[] = User::Login($loginparams);
		if($status['error_code'] == 0) {
			// Change the Password
			$data = array("password"=>$newpass);
			$license = $db->students()->where('email',$chparams['email']);
			$students->update($data);
			
			$response = array('error_code'=>0,'status'=>'success','description'=>"Password Changed Succesfully");
		} else {
			$response = array('error_code'=>1,'status'=>'failed','description'=>"Old Password is Incorrect");
		}
	} else {
		$response[] = array('error_code'=>1,'status'=>'failed','description'=>$errors);
	}
	return $response;	
  }

  
  public static function UpdateProfile($regparams) {
	   // Db Connection Utility
	  $db = Utility::mysqlRes();
	  $response = array();
	  $errors = array();
	  
	  //$name = isset($storeparams['name']) ? $storeparams['name'] : null;
  }
  
  public static function Activate($regparams) {
	  // Db Connection Utility
	  $db = Utility::mysqlRes();
	  $response = array();
	  $errors = array();
	  
	  $phone = isset($regparams['phone']) ? trim($regparams['phone']) : null;
	  $longt = isset($regparams['longt']) ? trim($regparams['longt']) : null;
	  $lat = isset($regparams['lat']) ? trim($regparams['lat']) : null;
	  
	  // Input Validation
	  if(strlen(trim($phone)) === 0) {
            $errors[] = "Please enter your phone number!";
	  }
	 
	  if(empty($errors)) {
		$regparams = array('phone'=>$phone,'longt'=>$longt,'lat'=>$lat);
                //Process Registration.
		$proc = $db->users()->insert($regparams);
		$response = array('error_code'=>0,'status'=>'ok','description'=>'Successfully Activated'); 
          } else {
		$errors = implode(",",$errors);
		$response = array('error_code'=>1,'status'=>'failed','description'=>$errors);
	  }
	  return $response; 
  }
  
  public static function AlreadyExists($dbcol, $data) {
	  $db = Utility::mysqlRes();
	  $status = false;
	  $response = array();
	  $total = $db->students()->where($dbcol, $data)->count();
	  
	  if ($total > 0) {
		  $status = false;
	  } else {
		  $status = true;
	  }
	  return $status;
  }
  
  
  public static function GetUserProfile($getparams) {
	$db = Utility::mysqlRes();
	$memberid = isset($getparams['userid']) ? $getparams['userid'] : null;
	try {
	  $members = $db->students()->where("email",$memberid);
	  if($members->count() == 0)
	  {
		 $response = array('error_code'=>1,'status'=>"success",'description'=>"empty"); 
	  } 
	  else {
		 foreach ($members as $member) {
			$response = $member;
		 }
	  }
	} catch (Exception $ex) {
			$response = array('error_code'=>1,'status'=>"failed",'description'=>$ex->getMessage());
	}
	return $response;
  }
  
  public static function GetUserLocation($params) {
	  $db = Utility::mysqlRes();
	  $q = strip_tags($params['q']);
	  
	  $results = $db->profs()->where("name LIKE ?","%$q%");
	  return $results;
  }
  
}